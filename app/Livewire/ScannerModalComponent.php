<?php

namespace App\Livewire;

use Livewire\Component;

class ScannerModalComponent extends Component
{
    public $isScannerOpen = false;

    protected $listeners = [
        'toggle-scanner' => 'toggleScanner',
    ];

    public function toggleScanner()
    {
        $this->isScannerOpen = !$this->isScannerOpen;
    }

    public function render()
    {
        return view('livewire.scanner-modal-component');
    }
}
