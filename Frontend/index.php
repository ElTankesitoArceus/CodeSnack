<?php include('./templates/header.php') ?>

<body class="bg-gradient-to-br from-zinc-900 to-zinc-800">
<?php include('./templates/nav.php') ?>
    <div class="flex gap-4 p-4">
        <div class="w-1/5 h-fit text-slate-200 bg-slate-950 border border-[#0c6b98] shadow-lg shadow-[#0c6b98]/30 rounded-md">
            <div class="m-auto text-center p-2 justify-center text-2xl mb-5 border-b bg-[#0d88bc] border-[#0c6b98] shadow-sm shadow-[#0c6b98]/50">
                Tags
            </div>
            <div id="tags-container" class="flex flex-wrap m-4 gap-2">
            </div>
            
        </div>
        <div id="snippet-container" class="h-fit columns-2 w-full">
        <!-- <div class="h-fit columns-2 w-full">
            <div class="rounded-xl bg-[#189bcc] border border-[#84d5f5] shadow-md shadow-[#84d5f5]/25 p-3 px-5 break-inside-avoid-column">
                <div class="text-4xl font-semibold">TITLE</div>
                <div class="flex gap-2 my-2">
                    <div class="px-2 text-slate-950 font-semibold rounded-lg bg-gradient-to-r from-teal-400 to-yellow-200 w-fit">
                        A
                    </div>
                    <div class="px-2 text-slate-950 font-semibold rounded-lg bg-orange-600 w-fit">
                        JAVA
                    </div>
                </div>
                <div>
                    Short dessc about the snippet
                </div>
                <div class="mt-5">
                    Modificada hace XX min
                </div>
                <div class="flex gap-2 flex-row-reverse">
                    <div class="p-2 px-3 bg-[#bee7f9] border-2 rounded-md">
                        Ver
                    </div>
                    <div class="p-2 px-3 border-2 rounded-md">
                        copiar
                    </div>
                </div>
            </div>
            <div class="rounded-xl bg-[#189bcc] border border-[#84d5f5] shadow-md shadow-[#84d5f5]/25 p-3 px-5 break-inside-avoid-column">
                <div class="text-4xl font-semibold">TITLE</div>
                <div class="flex gap-2 my-2">
                    <div class="px-2 text-slate-950 font-semibold rounded-lg bg-gradient-to-r from-teal-400 to-yellow-200 w-fit">
                        A
                    </div>
                    <div class="px-2 text-slate-950 font-semibold rounded-lg bg-orange-600 w-fit">
                        JAVA
                    </div>
                </div>
                <div>
                    Short dessc about the snippet
                </div>
                <div class="mt-5">
                    Modificada hace XX min
                </div>
                <div class="flex gap-2 flex-row-reverse">
                    <div class="p-2 px-3 bg-[#bee7f9] border-2 rounded-md">
                        Ver
                    </div>
                    <div class="p-2 px-3 border-2 rounded-md">
                        copiar
                    </div>
                </div>
            </div>
        </div> -->
        </div>
    </div>
</body>
<script src="./js/index.js"></script>