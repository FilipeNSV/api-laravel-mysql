<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionService
{
    /**
     * Get all transactions.
     *
     * @return Collection
     */
    public function getAllTransactions(): Collection
    {
        return Transaction::with('ownable')->get();
    }

    /**
     * Create a new transaction.
     *
     * @param array $data
     * @return Transaction
     */
    public function createTransaction(array $data): Transaction
    {
        return Transaction::create($data);
    }

    /**
     * Find a transaction by ID.
     *
     * @param int $id
     * @return Transaction|null
     */
    public function findTransactionById(int $id): ?Transaction
    {
        return Transaction::with('ownable')->find($id);
    }

    /**
     * Update a transaction.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateTransaction(int $id, array $data): bool
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            return $transaction->update($data);
        }

        return false;
    }

    /**
     * Delete a transaction.
     *
     * @param int $id
     * @return bool
     */
    public function deleteTransaction(int $id): bool
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            return $transaction->delete();
        }

        return false;
    }

    /**
     * Get all transactions for a specific user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTransactionsByUser(int $userId): Collection
    {
        return Transaction::where('user_id', $userId)->with('ownable')->get();
    }
}
