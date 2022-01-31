<div class="py-12" style="direction: rtl">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            {{-- @if (session()->has('message'))
            <div style="background: #4f545e;" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                role="alert">
                <div class="flex">
                    <div>
                        <p class="text-md" style="color: #fff;">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif --}}
            <button style="width: 15%; margin: 15px 0;" wire:click="create()"
                class="my-4 inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">
                اضافة فاتورة
            </button> 
            @if($isModalOpen)
            @include('livewire.create') 
            @endif 
            <input type="text" class="form-control" style="width: 100%;" placeholder="بحث....." wire:model="searchTerm" />
            <table class="table-fixed w-full" style="margin: 10px 0 10px 0;">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 w-10"></th>
                        <th class="border px-4 py-2">رقم العقد</th>
                        <th class="border px-4 py-2">قيمة الفاتورة</th>
                        <th class="border px-4 py-2">تاريخ الفاتورة</th>
                        <th class="border px-4 py-2">رقم الفاتورة</th>
                        <th class="border px-4 py-2">فترة الفاتورة من - ألى</th>
                        <th class="border px-4 py-2">نوع الشركة</th>
                        <th class="border px-4 py-2">مقدم الخدمة</th>
                        <th class="border px-4 py-2">حالة الفاتورة</th>
                        <th class="border px-4 py-2">ملاحظات</th>
                        <th class="px-4 py-2 w-10"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->index + 1 }}</td>
                        <td class="border px-4 py-2">{{ $invoice->contract_number }}</td>
                        <td class="border px-4 py-2">{{ $invoice->invoice_value }}</td>
                        <td class="border px-4 py-2">{{ $invoice->invoice_date }}</td>
                        <td class="border px-4 py-2">{{ $invoice->invoice_number }}</td>
                        <td class="border px-4 py-2">{{ $invoice->invoice_period_from }} - {{ $invoice->invoice_period_to }}</td>
                        <td class="border px-4 py-2">{{ $invoice->company_type }}</td>
                        <td class="border px-4 py-2">{{ $invoice->service_provider }}</td>
                        <td class="border px-4 py-2" @if($invoice->invoice_status === 'Done') style="color:#130fee;font-size:18px;" @endif @if($invoice->invoice_status === 'Not Done') style="color:red;font-size:18px;" @endif>{{ $invoice->invoice_status }}</td>
                        <td class="border px-4 py-2">{{ $invoice->note }}</td>
                        <td class="border px-4 py-2">
                            <button style="width: 100%;margin: 5px auto;" wire:click="edit({{ $invoice->id }})"
                                class="flex px-4 py-2 bg-gray-500 text-gray-900 cursor-pointer">تعديل</button>
                            {{-- wire:click="delete({{ $invoice->id }})" --}}
                            <button style="width: 100%;margin: 5px auto;" wire:click="confirmItemDeletion({{$invoice->id}})"
                                class="flex px-4 py-2 bg-red-100 text-gray-900 cursor-pointer">حذف</button>
                        </td> 
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $invoices->links() }}

            <x-jet-confirmation-modal wire:model="confirmingItemDeletion">
                <x-slot name="title"></x-slot>  
                <x-slot name="content">
                    هل انت متاكد من حذف هذه الفاتورة
                </x-slot>         
                <x-slot name="footer">
                    <x-jet-secondary-button style="margin-left: 10px;" wire:click="$set('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                         لا
                    </x-jet-secondary-button>        
                    <x-jet-danger-button class="ml-2" wire:click="deleteItem({{ $confirmingItemDeletion }})" wire:loading.attr="disabled">
                        نعم
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-confirmation-modal>

        </div>
    </div>
</div>