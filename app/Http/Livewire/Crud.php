<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\invoices;

class Crud extends Component
{
    use WithPagination;

    public $searchTerm;
    public $invoice_id,
           $contract_number,
           $invoice_value,
           $invoice_date,
           $invoice_number,
           $invoice_period_from,
           $invoice_period_to,
           $company_type, 
           $service_provider, 
           $invoice_status, 
           $note,
           $user_id;

    public $isModalOpen = 0;
    public $confirmingItemDeletion = false;

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.crud',[
            'invoices' => invoices::where('invoice_number','like', $searchTerm)->paginate(15)
        ]);
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->contract_number = '';
        $this->invoice_value = '';
        $this->invoice_date = '';
        $this->invoice_number = '';
        $this->invoice_period_from = '';
        $this->invoice_period_to = '';
        $this->company_type = '';
        $this->service_provider = '';
        $this->invoice_status = '';
        $this->note = '';
        $this->user_id = '';
        $this->invoice_id = null;
    }
    
    public function store()
    {
        $this->validate([
            'contract_number' => 'required|max:255',
            'invoice_value' => 'required|max:255',
            'invoice_date' => 'required|max:255',
            'invoice_number' => 'required|max:255|unique:invoices,invoice_number,'.$this->invoice_id,
            'invoice_period_from' => 'required|max:255',
            'invoice_period_to' => 'required|max:255',
            'company_type' => 'required|max:255',
            'service_provider' => 'required|max:255',
            'invoice_status' => 'required|max:255',
        ]);
    
        invoices::updateOrCreate(['id' => $this->invoice_id], [
            'contract_number' => $this->contract_number,
            'invoice_value' => $this->invoice_value,
            'invoice_date' => $this->invoice_date,
            'invoice_number' => $this->invoice_number,
            'invoice_period_from' => $this->invoice_period_from,
            'invoice_period_to' => $this->invoice_period_to,
            'company_type' => $this->company_type,
            'service_provider' => $this->service_provider,
            'invoice_status' => $this->invoice_status,
            'note' => $this->note,
            'user_id' => Auth::id(),
        ]);

        //session()->flash('message', $this->invoice_id ? 'تم تحديث الفاتورة بنجاح' : 'تم انشاء الفاتورة بنجاح');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => $this->invoice_id ? 'تم تحديث الفاتورة بنجاح' : 'تم انشاء الفاتورة بنجاح']);

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $invoice = invoices::findOrFail($id);
        $this->invoice_id = $id;
        $this->contract_number = $invoice->contract_number;
        $this->invoice_value = $invoice->invoice_value;
        $this->invoice_date = $invoice->invoice_date;
        $this->invoice_number = $invoice->invoice_number;
        $this->invoice_period_from = $invoice->invoice_period_from;
        $this->invoice_period_to = $invoice->invoice_period_to;
        $this->company_type = $invoice->company_type;
        $this->service_provider = $invoice->service_provider;
        $this->invoice_status = $invoice->invoice_status;
        $this->note = $invoice->note;
        $this->user_id = Auth::id();
    
        $this->openModalPopover();
    }
    
    public function confirmItemDeletion($id) 
    {
        $this->confirmingItemDeletion = $id;
    }
    public function deleteItem(invoices $invoice) 
    {
        $invoice->delete();
        $this->confirmingItemDeletion = false;
        //session()->flash('message', 'تم حذف الفاتورة بنجاح');
        $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'تم حذف الفاتورة بنجاح']);
    }
    // public function delete($id)
    // {
    //     invoices::find($id)->delete();
    //     session()->flash('message', 'تم حذف الفاتورة بنجاح');
    // }
    
}
