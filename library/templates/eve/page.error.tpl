<div class="flex h-screen items-center justify-center">
    <div class="w-full max-w-sm p-4 overflow-x-hidden overflow-y-auto md:inset-0 mx-auto">
        <!-- Modal content -->
        <div class="relative bg-white shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-center p-1 text-center border-b">
                <h3 class="text-xl font-medium text-white bg-red-500">
                    {$lang.error} {$error}
                </h3>
            </div>
            <!-- Modal body -->
            <div class="p-2">
                <p>
                    You made a mistake. <i>That's all I know.</i>
                </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-2 space-x-2 border-t border-gray-200">
                <button onclick="history.back()"
                    class="px-2 bg-red-500 text-white hover:bg-red-800">{$lang.back}</button>
            </div>
        </div>
    </div>
</div>