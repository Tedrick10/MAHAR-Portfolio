<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminTopbarExtras extends Component
{
    #[Computed]
    public function unreadCount(): int
    {
        return ContactMessage::query()->whereNull('read_at')->count();
    }

    /**
     * @return Collection<int, ContactMessage>
     */
    #[Computed]
    public function recentUnread(): Collection
    {
        /** @var Collection<int, ContactMessage> */
        return ContactMessage::query()
            ->whereNull('read_at')
            ->latest()
            ->limit(8)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.admin-topbar-extras');
    }
}
