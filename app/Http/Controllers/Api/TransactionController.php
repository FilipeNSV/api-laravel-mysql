<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use App\Services\TransactionService;
use App\Utils\OwnableValidator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * @var TransactionService
     */
    protected $transactionService;

    /**
     * TransactionController constructor.
     *
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the transactions.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $transactions = $this->transactionService->getAllTransactions();
        return response()->json($transactions);
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'type' => 'required|string|in:entry,exit',
            'user_id' => 'nullable|exists:users,id',
            'ownable_id' => 'required|integer',
            'ownable_type' => 'required|string',
        ]);

        $validatedOwnableType = OwnableValidator::validateOwnableTransaction($request->ownable_type, $request->ownable_id);

        if (!$validatedOwnableType) {
            return response()->json(['error' => 'Invalid ownable type or ownable ID does not exist.'], 400);
        }

        $request->merge(['ownable_type' => $validatedOwnableType]);

        $transaction = $this->transactionService->createTransaction($request->all());
        return response()->json($transaction, 201);
    }

    /**
     * Display the specified transaction.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $transaction = $this->transactionService->findTransactionById($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction);
    }

    /**
     * Update the specified transaction in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'type' => 'required|string|in:entry,exit',
            'user_id' => 'nullable|exists:users,id',
            'ownable_id' => 'required|integer',
            'ownable_type' => ['required', 'string', Rule::in([Product::class, Service::class])],
        ]);

        $validatedOwnableType = OwnableValidator::validateOwnableTransaction($request->ownable_type, $request->ownable_id);

        if (is_null($validatedOwnableType)) {
            return response()->json(['error' => 'Invalid ownable type or ownable ID does not exist.'], 400);
        }

        $request->merge(['ownable_type' => $validatedOwnableType]);

        $updated = $this->transactionService->updateTransaction($id, $request->all());

        if (!$updated) {
            return response()->json(['message' => 'Transaction not found or could not be updated'], 404);
        }

        return response()->json(['message' => 'Transaction updated successfully']);
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->transactionService->deleteTransaction($id);

        if (!$deleted) {
            return response()->json(['message' => 'Transaction not found or could not be deleted'], 404);
        }

        return response()->json(['message' => 'Transaction deleted successfully']);
    }

    /**
     * Get all transactions for a specific user.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getTransactionsByUser(int $userId): JsonResponse
    {
        if (!User::find($userId)) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $transactions = $this->transactionService->getTransactionsByUser($userId);

        if ($transactions->isEmpty()) {
            return response()->json(['message' => 'No transactions found for this user'], 404);
        }

        return response()->json($transactions);
    }
}
