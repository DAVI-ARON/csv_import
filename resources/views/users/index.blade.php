<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Csv Import</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite('resources/js/app.js')
</head>
<style>
    .dt-layout-row:has(.dt-search),
    .dt-layout-row:has(.dt-length),
    .dt-layout-row:has(.dt-paging) {
    display: none !important;
    }
</style>
<body>
    <div class="container  mx-auto">
        <div class="mt-8 drop-shadow-lg bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="bg-gray-100 border-b rounded-t-xl py-3 px-4 md:py-4 md:px-5 dark:bg-neutral-900 dark:border-neutral-700">
              <h2 class="mt-1 text-gray-500 dark:text-neutral-500">
                Leitor Excel - Laravel
              </h2>
            </div>
            <div class="p-4 md:p-5">
              <p class="text-sm text-gray-500 dark:text-neutral-400">
                Este leitor excel serve para cadastro de usuários, ele irá cadastrar usuários em massa apenas com nome e e-mail nessa respectiva ordem, caso o usuário já possua senha ele encriptografa a senha e caso o usuário ainda não possua senha ele cria uma senha aleatória e a criptografa.
              </p>

                @session('success')
                    <div class="mt-2 bg-teal-100 border border-teal-200 text-sm text-teal-800 rounded-lg p-4 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-success-label">
                        <p style="color: green">{!! $value !!}</p>
                    </div>
                @endsession

                @session('error')
                    <div class="mt-2 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                        <p style="color: red">{!! $value !!}</p>
                    </div>
                @endsession

                @if ($errors->any())
                    <div class="mt-2 bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert" tabindex="-1" aria-labelledby="hs-soft-color-danger-label">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data" class="p-4 mt-8 flex w-full bg-gray-100 rounded-md">
                    @csrf

                    <input type="file" name="file" id="file" accept=".csv" class="
                    block w-full border-2 border-dashed rounded-md p-2 text-sm text-gray-500 cursor-pointer
                    file:me-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-600 file:text-white
                    hover:file:bg-blue-700
                    file:disabled:opacity-50 file:disabled:pointer-events-none
                    dark:text-neutral-500
                    dark:file:bg-blue-500
                    dark:hover:file:bg-blue-400
                    ">
                    <button type="submit" id="import_file" class="px-4 inline-flex items-center text-sm font-medium rounded-lg border border-transparent text-teal-500 hover:bg-teal-100 focus:outline-none focus:bg-teal-100 hover:text-teal-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-teal-800/30 dark:hover:text-teal-400 dark:focus:text-teal-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload mr-2" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                        </svg>
                        Importar
                    </button>


                </form>

            </div>
        </div>

        <div class="flex flex-col" data-hs-datatable='{
            "pageLength": 10,
            "pagingOptions": {
            "pageBtnClasses": "min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
            }
        }'>
            <div class="overflow-x-auto min-h-[520px] mt-8">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                <table class="min-w-full">
                    <thead class="border-b border-gray-200 dark:border-neutral-700">
                    <tr>
                        <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                        <div class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700">
                            ID
                            <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500" d="m7 15 5 5 5-5"></path>
                            <path class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500" d="m7 9 5-5 5 5"></path>
                            </svg>
                        </div>
                        </th>

                        <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                        <div class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700">
                            Nome
                            <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500" d="m7 15 5 5 5-5"></path>
                            <path class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500" d="m7 9 5-5 5 5"></path>
                            </svg>
                        </div>
                        </th>

                        <th scope="col" class="py-1 group text-start font-normal focus:outline-none">
                        <div class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700">
                            E-mail
                            <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500" d="m7 15 5 5 5-5"></path>
                            <path class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500" d="m7 9 5-5 5 5"></path>
                            </svg>
                        </div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @foreach ($users as $user)
                        <tr>
                            <td class="p-3 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $user->id }}</td>
                            <td class="p-3 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $user->name }}</td>
                            <td class="p-3 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $user->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            </div>

            <div class="flex items-center space-x-1 mt-4 hidden" data-hs-datatable-paging="">
            <button type="button" class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-datatable-paging-prev="">
                <span aria-hidden="true">«</span>
                <span class="sr-only">Previous</span>
            </button>
            <div class="flex items-center space-x-1 [&>.active]:bg-gray-100 dark:[&>.active]:bg-neutral-700" data-hs-datatable-paging-pages=""></div>
            <button type="button" class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-datatable-paging-next="">
                <span class="sr-only">Next</span>
                <span aria-hidden="true">»</span>
            </button>
            </div>
        </div>

    </div>

    @vite('resources/js/app.js')

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
</body>
</html>
