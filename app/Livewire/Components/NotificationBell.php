<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $showDropdown = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notifications::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $this->unreadCount = Notifications::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notifications::find($notificationId);
        if ($notification && $notification->user_id === Auth::id()) {
            $notification->update(['is_read' => true]);
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        Notifications::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        $this->loadNotifications();
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function render()
    {
        return view('livewire.components.notification-bell');
    }
}
