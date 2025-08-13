<?php

namespace App\Observers;

use App\Models\user;

class userObserver
{
    /**
     * Handle the user "created" event.
     */
    public function created(user $user): void
    {
        //
    }

    /**
     * Handle the user "updated" event.
     */
    public function updated(user $user): void
    {
        //
    }

    /**
     * Before deleting user, delete all of its tagihan records
     */
    public function delete(user $user): void
    {
        $tagihan = $user->tagihan;
        foreach ($tagihan as $data) {
            if ($data->status == 'belum bayar') {
                $data->delete();
            } elseif ($data->status == 'lunas') {
                $data->user_id = null;
                $data->save();
            }
        }
    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(user $user): void
    {
        $tagihan = $user->tagihan;
        foreach ($tagihan as $data) {
            if ($data->status == 'belum bayar') {
                $data->delete();
            } elseif ($data->status == 'lunas') {
                $data->user_id = null;
                $data->save();
            }
        }
    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(user $user): void
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(user $user): void
    {
        $tagihan = $user->tagihan;
        foreach ($tagihan as $data) {
            if ($data->status == 'belum bayar') {
                $data->delete();
            } elseif ($data->status == 'lunas') {
                $data->user_id = null;
                $data->save();
            }
        }
    }
}
