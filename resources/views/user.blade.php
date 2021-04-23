<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center pt-4">
                            <h4> <i class="fas fa-user-tie"></i></h4>
                            <h3><strong>DATA USER </strong></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="@if($Edit === 1) col-md-8  @endif  mt-5  @if($Edit !== 1) col-md-12  @endif">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th width="223px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tr style="border-top: 1px solid #dee2e600 !important ; padding:0px !important;">
                                    <td colspan="4" style="border-top: 1px solid #dee2e600 !important ; padding:0px !important;" >
                                        <div class="alert alert-success Delalert-block" style="display: none;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong class="success-msg"></strong>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="@if($Edit === 1) col-md-4  @endif     mt-5 @if($Edit !== 1) col-md-12  @endif">
                            <div class="text-center">
                                @if($Edit === 1)
                                <div class="loading">
                                    <div class="mt-5 md:mt-0 md:col-span-2">
                                        <form>
                                            <input type="hidden" id="id" value="{{ $EditUser->id }}">
                                            <div class="alert alert-success alert-block" style="display: none;">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong class="success-msg"></strong>
                                            </div>
                                            @csrf
                                            <div class="bg-white sm:p-5 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                                <div class="grid ">
                                                    <div class="col-span-12 sm:col-span-12 text-left">
                                                        <label class="block font-medium text-sm text-gray-700"
                                                            for="name">
                                                            Name
                                                        </label>
                                                        <input class="form-control " id="name" type="text"
                                                            wire:model.defer="state.name" value="{{ $EditUser->name }}"
                                                            autocomplete="name">
                                                        @error('name') {{ $message }} @enderror
                                                        <span id="validateName" class="text-red"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-white sm:p-5 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                                <div class="grid ">
                                                    <div class="col-span-12 sm:col-span-12 text-left">
                                                        <label class="block font-medium text-sm text-gray-700"
                                                            for="email">
                                                            Email
                                                        </label>
                                                        <input class="form-control " id="email" type="text"
                                                            wire:model.defer="state.email"
                                                            value="{{ $EditUser->email }}" autocomplete="email">
                                                        @error('email') {{ $message }} @enderror
                                                        <span id="validateEmail" class="text-red"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center justify-end px-4 py-3  text-right   sm:rounded-bl-md sm:rounded-br-md ">
                                                <button type="submit"
                                                    class="w-100 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition btn-submit">
                                                    UPDATE
                                                </button>

                                                <a href="/users"
                                                    class="w-100 inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition"
                                                    wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                                                    BACK
                                                </a>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>