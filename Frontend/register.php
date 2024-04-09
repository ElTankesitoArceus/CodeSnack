<?php include('./templates/header.php') ?>

<body class="bg-gradient-to-br from-zinc-900 to-zinc-800 ">
    <div class="w-1/3 min-w-[40rem] flex h-full m-auto ">
        <div class="grid-cols-1 h-fit m-auto p-10 rounded-lg gap-56 content-around border-[#8ccee6] border bg-gradient-to-bl from-slate-800 to-zinc-900 text-slate-100 shadow-lg shadow-slate-800/50 hover:shadow-teal-900/50 hover:border-[#189CCC] transition ease-in-out">
            <h1 class="text-4xl font-bold mb-5 text-center ">Register account</h1>
            <div id="error-container" class="bg-red-400/[.7] rounded-md px-5 py-2" style="display: none;">sdf</div>
            <div class="grid-cols-1 m-auto">
                <label for="username" class="text-lg">Username</label>
                <input type="text" id="username" placeholder="username" class="w-full h-10 rounded border-2 p-2 outline-none border-[#a3d7eb] bg-[#e8f5fa] text-zinc-950 transition ease-in-out focus:border-[#189CCC]"/>
            </div>
            <div class="m-auto">
                <label for="email" class="text-lg">Email</label> 
                <input type="email" id="email" placeholder="mail@server.com" class="w-full h-10 rounded border-2 p-2 outline-none border-[#a3d7eb] bg-[#e8f5fa] text-zinc-950 transition ease-in-out focus:border-[#189CCC]"/>
            </div>
            <div class="m-auto grid grid-cols-2 items-end gap-5">
                <div class="h-auto">
                    <label for="password" class="text-lg">Password</label>
                    <input type="password" id="password" placeholder="**********" class="w-full h-10 rounded border-2 p-2 outline-none border-[#a3d7eb] bg-[#e8f5fa] text-zinc-950 transition ease-in-out focus:border-[#189CCC]"/>
                </div>
                <div class="h-auto">
                    <label for="confirm-password" class="text-lg">Confirm password</label>
                    <input type="password" id="confirm-password" placeholder="**********" class="w-full h-10 rounded border-2 p-2 outline-none border-[#a3d7eb] bg-[#e8f5fa] text-zinc-950 transition ease-in-out focus:border-[#189CCC]"/>
                </div>
            </div>
            <div class="m-auto mt-5">
                <button id="register-button" class="w-1/3 my-2 p-3 rounded-xl bg-[#189CCC] transition ease-in-out hover:bg-[#43c0ed] hover:text-[#fff] hover:shadow-md hover:shadow-teal-500/50 active:bg-[#0d89bc]">Register</button>
            </div>
        </div>
    </div>
</body>
<script src="./js/register.js"></script>