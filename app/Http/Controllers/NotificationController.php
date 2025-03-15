<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markReadByType($type)
    {
        $user = Auth::user();

        if ($type === 'entreprise') {
            $user->unreadNotifications
                 ->where('type', 'App\Notifications\NouvelleEntrepriseNotification')
                 ->markAsRead();
            return redirect()->route('entreprise.index');
        } elseif ($type === 'demande') {
            $user->unreadNotifications
                 ->where('type', 'App\Notifications\NouvelleDemandeNotification')
                 ->markAsRead();
            return redirect()->route('demande.index');
        }
        return redirect()->back();
    }
}
