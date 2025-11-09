@extends('website.layout.app')

@section('title', 'Products')
@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-5">
        <div class="layout-content-container mx-auto flex max-w-7xl flex-col flex-1">
            <!-- Breadcrumbs Component -->
            <div class="flex flex-wrap gap-2 p-4">
                <a class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal" href="#">Home</a>
                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">/</span>
                <a class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal" href="#">Toys</a>
                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">/</span>
                <span class="text-text-light dark:text-text-dark text-sm font-medium leading-normal">Gerry the Gentle
                    Giraffe</span>
            </div>
            <!-- Main Product Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 mt-6">
                <!-- Left Column: Image Gallery -->
                <div class="flex flex-col gap-4">
                    <!-- Large Image -->
                    <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl shadow-lg"
                        data-alt="Main view of a plush giraffe toy named Gerry"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCGf_v7sPKoaqgfVQXqq-rgJe6GDEaH2bP32KTIyFNCtrN36hDSgmw0xmgHwghuPP2UWE8GQHRVbXfWKg5neBQ3p_T2xxcPKTzyry-p6gPMJlZt4UTZJ3VgA3_3w91aGxoPBZbmToM2yX10mEPNN48FEuIfb6YDggxagjlLw3ZfhrE9RU3wCl8TIh8wcsh2yuwBmjhYTuakBcO81CjwzuyGLAW_aRn8lah1oP0BRAdjj0BjjhjzB0pQz5pidj8gDZ431ogpczJBUII");'>
                    </div>
                    <!-- Thumbnail Grid -->
                    <div class="grid grid-cols-4 gap-4">
                        <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-lg border-2 border-primary"
                            data-alt="Side view of the plush giraffe"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBFxZUAmhAt2amSgEMYm822qGjr2nTYmVkp_rj0xiWl1MwxFjc5Cifzdb6xM1jd6KRMJtvm9QYYGOJ3OdFtBfNaHTaSOZ3nIYVArZfE5SkL8CU0U0-TGfr5R3t86JhSpYLeI5hhR0dKfORV0fjxEHESSnJIxpJeRTdzE_zJYRKtD8KraiJfLaXbB4uqlDQeD7c19eo0DpKNvv_aCeI6GBQ1pY3luKTz66fGa7OTnztP3TdmzV_rx47nniHuP0zQ48FhZQGTj-siRKc");'>
                        </div>
                        <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-lg"
                            data-alt="Close up of the giraffe's face"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBP6gZ0dx43w_ePAdytE2Syc8OGAiVhRLMq7k6wsjvJJti77msMSQu5cmouQyEY0EAEw30Uo-PniApwT8Z0-fqj0ScKe99Gmvspq0n4AbLbXMhzcbc1ugAojNZl7oxeY5xrngC-uaWTZnbA4AgZ_YkYkzI-W05kA3kx-Otxt8-xL2DH4HREHKgcIkdJDRg1mAtNiiE_xlMyha6WKWiPVjtWcLcQ8GpIpP037JDaWieSZujE1hO1pKUxL_x01h_3xVC4LiGwX7UqiMo");'>
                        </div>
                        <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-lg"
                            data-alt="Child playing with the plush giraffe"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC_P3xmupvWlmW_SGqLeNgPRRVsW462Mgi67VJIs5OwTgtXdHqwQnBzufQmkMlIeQwtXK-jheCo7jRYxdvLb9kpKWjApVAIWnqrptQ_9C90PiQ825VFDbiW1NKEMowTw1T1tKUN9jL6I9PQa6APkvEnPLuwUGpUs10eIGSP-C7R55NJ48kTxwHxIsQUIFXlhYtnGeEpW_Be5iTaPjYQLazGP9m--t3wF-DGa8pzOFb3AOM3NK-xZJRe9dHe4Uv_qZIG6-cTE6gkNpM");'>
                        </div>
                        <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-lg"
                            data-alt="The plush giraffe in a nursery setting"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDNtUbD3Rp51jY-anpu91d3gjLEd80fUuEppxsGMwMp_IsuIcuqsQWlsq4l-bLTNLby4TislM3DHRpX7wTwiRFSYrtp6CtMl9i0rpw_aOEIcSSVzutKJgyC8PYPaq1R_WUqi9UrOlZ7e6XpQ0ejjzvgF9lTy_TcQURGMFsj4aVP__muYhDLEfW3Au-bhuUaaOqgBAoQwYfg4iO1LjKX9iXDLiJtZtRdxWpvegxGQ3cimPqO6jKQ_L_FkxNjI0ZoNf-DYhYbUbAWpOw");'>
                        </div>
                    </div>
                </div>
                <!-- Right Column: Product Info -->
                <div class="flex flex-col gap-6 py-4">
                    <!-- Product Heading -->
                    <div class="flex flex-col gap-2">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">By Safari Friends Co.</p>
                        <h1
                            class="text-text-light dark:text-text-dark text-4xl font-black leading-tight tracking-[-0.033em]">
                            Gerry the Gentle Giraffe</h1>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex text-primary">
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star_half</span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">4.7 (128 Reviews)</p>
                        </div>
                    </div>
                    <!-- Price -->
                    <p class="text-4xl font-bold text-text-light dark:text-text-dark">$34.99</p>
                    <!-- Options -->
                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="text-sm font-bold text-text-light dark:text-text-dark mb-2 block">Size</label>
                            <div class="flex gap-3">
                                <button
                                    class="px-4 py-2 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-background-dark text-sm">Small
                                    (12")</button>
                                <button
                                    class="px-4 py-2 rounded-lg border-2 border-primary bg-primary/20 text-sm font-bold">Medium
                                    (18")</button>
                                <button
                                    class="px-4 py-2 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-background-dark text-sm">Large
                                    (24")</button>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="text-sm font-bold text-text-light dark:text-text-dark">Quantity</label>
                            <div class="flex items-center border border-border-light dark:border-border-dark rounded-lg">
                                <button class="px-3 py-2 text-lg text-gray-500 dark:text-gray-400">-</button>
                                <input
                                    class="w-12 text-center border-0 bg-transparent focus:ring-0 text-text-light dark:text-text-dark"
                                    type="text" value="1" />
                                <button class="px-3 py-2 text-lg text-gray-500 dark:text-gray-400">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex items-center gap-4 mt-4">
                        <button
                            class="flex-1 text-white bg-accent-coral hover:opacity-90 transition-opacity flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 gap-2 text-base font-bold leading-normal tracking-[0.015em] px-6">Add
                            to Cart</button>
                        <button
                            class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 bg-gray-200 dark:bg-white/10 text-text-light dark:text-text-dark gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-4">
                            <span
                                class="material-symbols-outlined text-text-light dark:text-text-dark">favorite_border</span>
                        </button>
                    </div>
                    <!-- Safety Badges -->
                    <div class="flex items-center gap-4 border-t border-border-light dark:border-border-dark pt-6 mt-2">
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-green-500">health_and_safety</span>
                            <span>BPA-Free</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-green-500">spa</span>
                            <span>Non-Toxic Dyes</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-green-500">eco</span>
                            <span>Organic Cotton</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Details Accordion Section -->
            <div class="mt-16">
                <div class="border-b border-border-light dark:border-border-dark">
                    <h3 class="py-4 text-lg font-bold flex justify-between items-center cursor-pointer">
                        <span>Description</span>
                        <span class="material-symbols-outlined">expand_more</span>
                    </h3>
                    <div class="pb-6 text-gray-600 dark:text-gray-300 space-y-3">
                        <p>Meet Gerry, the friendliest giraffe in the savanna! Made from ultra-soft, GOTS-certified organic
                            cotton, Gerry is designed for endless cuddles and imaginative adventures. His gentle smile and
                            long, huggable neck make him the perfect companion for your little one, from naptime to
                            playtime.</p>
                        <p>Each Gerry is lovingly handcrafted with non-toxic, baby-safe dyes, ensuring a safe and healthy
                            friend for your child. His embroidered eyes mean no small parts, making him suitable for all
                            ages.</p>
                    </div>
                </div>
                <div class="border-b border-border-light dark:border-border-dark">
                    <h3
                        class="py-4 text-lg font-bold flex justify-between items-center cursor-pointer text-gray-500 dark:text-gray-400">
                        <span>Specifications</span>
                        <span class="material-symbols-outlined">expand_more</span>
                    </h3>
                </div>
                <div class="border-b border-border-light dark:border-border-dark">
                    <h3
                        class="py-4 text-lg font-bold flex justify-between items-center cursor-pointer text-gray-500 dark:text-gray-400">
                        <span>Shipping &amp; Returns</span>
                        <span class="material-symbols-outlined">expand_more</span>
                    </h3>
                </div>
            </div>
            <!-- Customer Reviews Section -->
            <div class="mt-16">
                <h2 class="text-3xl font-bold mb-6">Customer Reviews</h2>
                <div class="bg-white dark:bg-background-dark/50 rounded-xl p-8 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div
                            class="flex flex-col items-center justify-center gap-2 border-r border-border-light dark:border-border-dark pr-8">
                            <p class="text-5xl font-black text-primary">4.7</p>
                            <div class="flex text-primary">
                                <span class="material-symbols-outlined">star</span><span
                                    class="material-symbols-outlined">star</span><span
                                    class="material-symbols-outlined">star</span><span
                                    class="material-symbols-outlined">star</span><span
                                    class="material-symbols-outlined">star_half</span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Based on 128 reviews</p>
                        </div>
                        <div class="col-span-2 flex flex-col gap-2 text-sm">
                            <!-- Rating bars -->
                            <div class="flex items-center gap-2"><span class="w-12">5 star</span>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" style="width: 80%"></div>
                                </div><span>102</span>
                            </div>
                            <div class="flex items-center gap-2"><span class="w-12">4 star</span>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" style="width: 15%"></div>
                                </div><span>19</span>
                            </div>
                            <div class="flex items-center gap-2"><span class="w-12">3 star</span>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" style="width: 3%"></div>
                                </div><span>4</span>
                            </div>
                            <div class="flex items-center gap-2"><span class="w-12">2 star</span>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" style="width: 2%"></div>
                                </div><span>2</span>
                            </div>
                            <div class="flex items-center gap-2"><span class="w-12">1 star</span>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" style="width: 1%"></div>
                                </div><span>1</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Individual Reviews -->
                <div class="mt-8 space-y-6">
                    <div class="flex gap-4 border-b border-border-light dark:border-border-dark pb-6">
                        <div class="w-12 h-12 rounded-full bg-cover bg-center" data-alt="Avatar of Sarah K."
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAzxlSNrm5NMgSfQ89EDLCQI61e8qV6On6zKkn09o39DkVzmgw-ZcTv9wI0xdPkr_CR8Ex_U9OrVhuNadI0WH7tCokH8ylzaND3lgkkrHtGWBTSOsmfJvL7W3IPceDhY2GsRIZcLSVlTBt4N8fRLCJDis64wAJhzMm11VflPjYJyZFrCDUu-h78ain20wn0-NhBCBONGlIsIDrpj4mepw89F2kPzLNSufzVhano3A15jjhsPJZe6HvOQ1taLg3J5ZBefiYV5elPnXQ')">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-bold">Sarah K.</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">2 weeks ago</p>
                            </div>
                            <div class="flex text-primary my-1"><span
                                    class="material-symbols-outlined text-base">star</span><span
                                    class="material-symbols-outlined text-base">star</span><span
                                    class="material-symbols-outlined text-base">star</span><span
                                    class="material-symbols-outlined text-base">star</span><span
                                    class="material-symbols-outlined text-base">star</span></div>
                            <p class="text-gray-600 dark:text-gray-300">So incredibly soft! My daughter absolutely loves
                                her new giraffe. It's the perfect size for her to carry everywhere. Wonderful quality.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 border-b border-border-light dark:border-border-dark pb-6">
                        <div class="w-12 h-12 rounded-full bg-cover bg-center" data-alt="Avatar of Mark T."
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDpZQNNoW5nq2TZYy6zInzLHyYXUJb-TBJapk7Ot5qQ1YfxO9LIatol4o5ydEVUMrzwGXZr3g_kyVLY6JtgCypdyXoyKwfw_LxW1GMnjD46jHbZ6zUgc_6-90YkVJf6pvepyyQiYk9F7XOiAglZAi3irUzmo4CTMLpe289jxjKZ9B9TeNqL7gOD62wLCDQT7lfMD3zD6ggqs2U09WIFvObYcpM2WZ0CQozcZyPbGWgBtPO4v4dg7ipDLSyz5dLqbmJ1YQVoeW0_yks')">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-bold">Mark T.</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">1 month ago</p>
                            </div>
                            <div class="flex text-primary my-1"><span
                                    class="material-symbols-outlined text-base">star</span><span
                                    class="material-symbols-outlined text-base">star</span><span
                                    class="material-symbols-outlined text-base">star</span><span
                                    class="material-symbols-outlined text-base">star</span><span
                                    class="material-symbols-outlined text-base">star_outline</span></div>
                            <p class="text-gray-600 dark:text-gray-300">Great toy, very well-made. Feels durable and safe.
                                A little pricier than others, but you can feel the quality difference. Would recommend.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- You Might Also Like Section -->
            <div class="mt-24">
                <h2 class="text-3xl font-bold mb-6 text-center">You Might Also Like</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="flex flex-col gap-3 group">
                        <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl transition-transform group-hover:scale-105"
                            data-alt="Plush elephant toy"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBXwrn1-8XSiscTBHLsHJyLS04ci-x9cOufdAPcoQHdA2VOYy6UslWJePGfKkvwZLhk-WUMyrGd6xAFRzZchRNY3O8peUtdKoMfITof5ZRxG-OkWL6kxF3ywdmiJXhgaSSgt6joibrPIqDsb6P3AFL7gmuw-40pIdNmr5N0vyR3HcpdEXEcZOa1tu8n40EZtIa8u-5SZqWqAnOc2RSYOhmxFS6MgOAl5tXsjlbcza1JblhD2iwdpKZZMKd9pu34pxuRc_gFZNowtfU");'>
                        </div>
                        <div class="text-center">
                            <h4 class="font-semibold">Elara the Elephant</h4>
                            <p class="text-gray-500 dark:text-gray-400">$29.99</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 group">
                        <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl transition-transform group-hover:scale-105"
                            data-alt="Wooden block set"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCHB0W8pjET1dscN9qmzI8-5tV4dfmAIPy9uaVllrL6QP2oCRSxBc63533xyAquXihaUzmH8r8GCBGRLMC8grBN6PHDgTiHqG9Dg8IT5br55T6zL6oonq265ZOeK-HlywjeXLW1czcn1KjSnQ_IBxh4p7CQKgWtj7sVI8RRUfQqYnTyKfaAp7Dq--oHLf-bo5FQ48yx5j2xIvgDDhFHPRrysqOkYB7SYdKblYzx6D1Y9B3R3idF5gRBxC9YPTt1A9pwOVpNsJ4_65Y");'>
                        </div>
                        <div class="text-center">
                            <h4 class="font-semibold">Rainbow Building Blocks</h4>
                            <p class="text-gray-500 dark:text-gray-400">$45.00</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 group">
                        <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl transition-transform group-hover:scale-105"
                            data-alt="Soft baby blanket"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAOQv0_AomZVPRr9fIJFZVS1zcz8vxMHRA5neOBs3zhL4bKXwOm49szDl_M4LdOQcJICesLwan1DhwUETXD7E49-TTk3QztEbWowgYaMCMB7QC0R2NBaqQgxFHFrDvWapwxGCSx4KjszzCDVI7hjLgfg6QfpOYsfTPt5dkzxf2Yaco3kr2Fc0xf8Aat1mn6H-NJhJ2VNLsi8WTqppqaaxhwU1a3e7DorxPnBPGHLN0Z0BMMUe3niG0ZYFVfexO6pDy1vMT5-6UYf10");'>
                        </div>
                        <div class="text-center">
                            <h4 class="font-semibold">Cozy Cloud Blanket</h4>
                            <p class="text-gray-500 dark:text-gray-400">$39.99</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 group">
                        <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl transition-transform group-hover:scale-105"
                            data-alt="Plush lion toy"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCQ52IbUCnizWBRxHoxc1VOvK73a4TqSwQGtLgZ4DSUZltD40Ki7TWFf4jxU-9nWLddXoRcCruGPWSGPwiSD4cqHe4OA85EV8qWckX35hXkYwz7H-BxLTMFaXVERJNoH3ZieyD1IZkjm2Gx6yznuohJ8xNWxVHNKpqTfj44FVefWvjABdIoQRB-1t3VEm9lWtVzU3lEf6yjqX-EJtEIvE2TESi5uJl8GG8OiaO9o3V1yWWvqmjmRgq2Dp9J76xXc5A9NMthHa5Geo0");'>
                        </div>
                        <div class="text-center">
                            <h4 class="font-semibold">Leo the Brave Lion</h4>
                            <p class="text-gray-500 dark:text-gray-400">$29.99</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
