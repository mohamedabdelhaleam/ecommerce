@extends('website.layout.app')

@section('title', 'Products')
@section('contents')
    <main class="px-4 sm:px-8 lg:px-16 py-8">
        <div class=" mx-auto">
            <!-- Breadcrumbs -->
            <div class="flex flex-wrap gap-2 mb-6">
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Home</a>
                <span class="text-sm font-medium">/</span>
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Toys</a>
                <span class="text-sm font-medium">/</span>
                <span class="text-sm font-medium text-text-light/70 dark:text-text-dark/70">Building Blocks</span>
            </div>
            <!-- PageHeading -->
            <div class="flex flex-wrap justify-between gap-3 mb-8">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tighter">All Our Magical Toys</h1>
            </div>
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Sticky Filter & Sort Sidebar -->
                <aside class="lg:w-1/4 xl:w-1/5 lg:sticky top-28 h-fit">
                    <div class="flex flex-col">
                        <div class="flex flex-col mb-6">
                            <h2 class="text-xl font-bold">Filter &amp; Sort</h2>
                            <p class="text-sm text-text-light/70 dark:text-text-dark/70">Find the perfect gift</p>
                        </div>
                        <div class="flex flex-col space-y-4">
                            <!-- Sort Dropdown -->
                            <div>
                                <label class="block text-sm font-medium mb-2" for="sort-by">Sort by</label>
                                <select
                                    class="w-full rounded border-stone-300 dark:border-stone-700 bg-background-light dark:bg-background-dark focus:border-primary focus:ring-primary text-sm"
                                    id="sort-by">
                                    <option>Popularity</option>
                                    <option>Newest</option>
                                    <option>Price: Low to High</option>
                                    <option>Price: High to Low</option>
                                </select>
                            </div>
                            <!-- Accordions for filters -->
                            <div class="flex flex-col">
                                <details class="flex flex-col border-t border-stone-200 dark:border-stone-800 py-2 group"
                                    open="">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-2">
                                        <p class="text-sm font-medium">Age Group</p>
                                        <span
                                            class="material-symbols-outlined text-xl transition-transform group-open:rotate-180">expand_more</span>
                                    </summary>
                                    <div class="space-y-2 pt-2 text-sm">
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> 0-2 years</label>
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> 3-5 years</label>
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> 6-8 years</label>
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> 9+ years</label>
                                    </div>
                                </details>
                                <details class="flex flex-col border-t border-stone-200 dark:border-stone-800 py-2 group"
                                    open="">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-2">
                                        <p class="text-sm font-medium">Category</p>
                                        <span
                                            class="material-symbols-outlined text-xl transition-transform group-open:rotate-180">expand_more</span>
                                    </summary>
                                    <div class="space-y-2 pt-2 text-sm">
                                        <label class="flex items-center gap-2"><input checked=""
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> Building Blocks</label>
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> Puzzles</label>
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> Stuffed Animals</label>
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> Art &amp; Craft</label>
                                    </div>
                                </details>
                                <details class="flex flex-col border-t border-stone-200 dark:border-stone-800 py-2 group">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-2">
                                        <p class="text-sm font-medium">Brand</p>
                                        <span
                                            class="material-symbols-outlined text-xl transition-transform group-open:rotate-180">expand_more</span>
                                    </summary>
                                    <div class="space-y-2 pt-2 text-sm">
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> Blocktastic</label>
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> Creative Kids</label>
                                        <label class="flex items-center gap-2"><input
                                                class="rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                type="checkbox" /> Fun Times</label>
                                    </div>
                                </details>
                                <details
                                    class="flex flex-col border-t border-b border-stone-200 dark:border-stone-800 py-2 group">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-2">
                                        <p class="text-sm font-medium">Price Range</p>
                                        <span
                                            class="material-symbols-outlined text-xl transition-transform group-open:rotate-180">expand_more</span>
                                    </summary>
                                    <div class="pt-4 pb-2 text-sm">
                                        <input
                                            class="w-full h-2 bg-stone-200 rounded-lg appearance-none cursor-pointer dark:bg-stone-700 accent-primary"
                                            max="100" min="0" type="range" value="50" />
                                        <div class="flex justify-between mt-2 text-xs"><span>$0</span><span>$100+</span>
                                        </div>
                                    </div>
                                </details>
                            </div>
                            <!-- Clear All Button -->
                            <button
                                class="w-full text-sm font-semibold py-2.5 rounded bg-stone-200 dark:bg-stone-800 hover:bg-stone-300 dark:hover:bg-stone-700 transition-colors">Clear
                                All Filters</button>
                        </div>
                    </div>
                </aside>
                <!-- Product Grid -->
                <div class="w-full lg:w-3/4 xl:w-4/5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        <!-- Product Card 1 -->
                        <div
                            class="group relative overflow-hidden rounded-xl bg-white dark:bg-background-dark/50 shadow-sm hover:shadow-xl transition-all duration-300 border border-stone-200 dark:border-stone-800">
                            <div class="absolute top-3 left-3 z-10">
                                <span
                                    class="inline-block bg-primary text-white text-xs font-bold px-2.5 py-1 rounded-full">NEW</span>
                            </div>
                            <a class="block" href="#">
                                <img class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
                                    data-alt="Colorful wooden building blocks arranged in a castle shape"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0V3ZQhmW3cK4ui--Zuou5lbE_Q_LMtofp29nh9tb0a22qxtN4NH6lvf2ES7DKyjxlKtTfmryqB4sdPpHtWfEwOgQH6zppUaM2ZRsuwKb1W2mJNAyd65uymsdTGypy2jjpYATeE7_A_sUzhmAF228McGdISzuVZwnGsQnWaNZospUxl802_F7c6pQ4fusoMx_MEw-RWAX5etUwahtoj8h7UvUQwrUblaH27GcRDMi82g2-CjeY-F0IdR-gWhzaDjmu9VWWX-9GbAI" />
                            </a>
                            <div class="p-4">
                                <p class="text-xs text-text-light/60 dark:text-text-dark/60">Blocktastic</p>
                                <h3 class="font-bold text-lg mt-1"><a href="#">Rainbow Castle Blocks</a></h3>
                                <p class="font-bold text-primary mt-2">$29.99</p>
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-white dark:from-background-dark/80 to-transparent opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <button
                                    class="w-full bg-primary text-white font-bold py-2.5 rounded-lg text-sm transition-transform hover:scale-105">Add
                                    to Cart</button>
                            </div>
                        </div>
                        <!-- Product Card 2 -->
                        <div
                            class="group relative overflow-hidden rounded-xl bg-white dark:bg-background-dark/50 shadow-sm hover:shadow-xl transition-all duration-300 border border-stone-200 dark:border-stone-800">
                            <a class="block" href="#">
                                <img class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
                                    data-alt="A child playing with natural wood building blocks"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBc046RWern4kvRL5WL93jO0DDBSH6k5lDf8bxUCSYJsa4PrdF8pClz6kMvU1ulBTInaZZ02jTUUf6xgp1Fd9ZyWIIzJvSl2hn8FdLFwM8ScjdOjiBtJha6CzatwHmDpMsYfPTiPPfeN5dP_aKPqYCRb9oWds31Qv-qQ3KCh1DhkkxI2nTLSJNPpTQGhHrKLSvEGXBNfCC1xpkRwX-SLUQTkqbg8OMPMBY071MblVOq5wNdSy3qneh7O81a4FWAF__kLHAVkLn4idg" />
                            </a>
                            <div class="p-4">
                                <p class="text-xs text-text-light/60 dark:text-text-dark/60">Creative Kids</p>
                                <h3 class="font-bold text-lg mt-1"><a href="#">Natural Wood Cubes</a></h3>
                                <p class="font-bold text-primary mt-2">$19.99</p>
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-white dark:from-background-dark/80 to-transparent opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <button
                                    class="w-full bg-primary text-white font-bold py-2.5 rounded-lg text-sm transition-transform hover:scale-105">Add
                                    to Cart</button>
                            </div>
                        </div>
                        <!-- Product Card 3 -->
                        <div
                            class="group relative overflow-hidden rounded-xl bg-white dark:bg-background-dark/50 shadow-sm hover:shadow-xl transition-all duration-300 border border-stone-200 dark:border-stone-800">
                            <div class="absolute top-3 left-3 z-10">
                                <span
                                    class="inline-block bg-[#A8D8B9] text-text-light text-xs font-bold px-2.5 py-1 rounded-full">SALE</span>
                            </div>
                            <a class="block" href="#">
                                <img class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
                                    data-alt="A large set of interlocking plastic building bricks in various colors"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAa2pyUzUOvsEk9YO0A7tBJUs6FtFTgb3VKZkdh9JVI3NLwJ0Bl_f4lHN8_xlbK-zktFBufi9ZYvde8BzF-v0g_XJ9DddRne40dDcAesKKpC-dyTsVyvHk51Ld2boXaIPm3c-BHHVzyBbWprDurEgNkv4pxdTVvjeGae_NKlQgPpe4dhKbGUHrQXbAoECcJlBKexHgzfyIVwXZbmz_bsesUcvW5yYXx5ku6dNptxndc4LhQ7duRMQUDPZxsWVIq6-0Tde4-ZmmkTiE" />
                            </a>
                            <div class="p-4">
                                <p class="text-xs text-text-light/60 dark:text-text-dark/60">Fun Times</p>
                                <h3 class="font-bold text-lg mt-1"><a href="#">Mega Brick Set</a></h3>
                                <p class="font-bold text-primary mt-2"><span
                                        class="line-through text-text-light/50 dark:text-text-dark/50 mr-2">$45.00</span>
                                    $35.99</p>
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-white dark:from-background-dark/80 to-transparent opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <button
                                    class="w-full bg-primary text-white font-bold py-2.5 rounded-lg text-sm transition-transform hover:scale-105">Add
                                    to Cart</button>
                            </div>
                        </div>
                        <!-- Product Card 4 -->
                        <div
                            class="group relative overflow-hidden rounded-xl bg-white dark:bg-background-dark/50 shadow-sm hover:shadow-xl transition-all duration-300 border border-stone-200 dark:border-stone-800">
                            <a class="block" href="#">
                                <img class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
                                    data-alt="Soft alphabet blocks for toddlers"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDB5toLn4fFSPnHV_PfWmjyRpNkofamWhLcyu3tZM1wmXVnay5eXMP2guzEqck5Xa00qXoBXUcTN7kXHoKk8t8mhHD2p0Q4PALLJAvEWn4nZgV47J-mvItCXScxM4ZoAlGV1K176spYSzKavLDTfwOKRO92Lp6w5pGGn0qhwugJCNufeixJXncliT46dMoDHJW2S_PiXOZkpVYzM9g8MfVfNX8aSXwJGfCw_KG3_yrDafckzVwWF7mcvxIdpGxlgqFO75EuLxcAjZg" />
                            </a>
                            <div class="p-4">
                                <p class="text-xs text-text-light/60 dark:text-text-dark/60">Blocktastic</p>
                                <h3 class="font-bold text-lg mt-1"><a href="#">Soft ABC Blocks</a></h3>
                                <p class="font-bold text-primary mt-2">$24.99</p>
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-white dark:from-background-dark/80 to-transparent opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <button
                                    class="w-full bg-primary text-white font-bold py-2.5 rounded-lg text-sm transition-transform hover:scale-105">Add
                                    to Cart</button>
                            </div>
                        </div>
                        <!-- Product Card 5 -->
                        <div
                            class="group relative overflow-hidden rounded-xl bg-white dark:bg-background-dark/50 shadow-sm hover:shadow-xl transition-all duration-300 border border-stone-200 dark:border-stone-800">
                            <a class="block" href="#">
                                <img class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
                                    data-alt="Magnetic building tiles in various geometric shapes"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCL8MBEgHNcGhaJ1o3J-ML3Y1q0kGewKS1XAIowa1t8k3WLLfjXUbBff2k9EXnKacuvrSIy-Uu7Ca2SzMpFC4CPlw0Z0aDgskdD9s_Qq_aByFotK_mGKZxtR1Cs2j7M9v40IdsA9hDbQ9y3PmP6KAqWw0Nq-D2HG6EwREhwT_bc9mA3JbjF90SjzpnsKjDkI_NfZR46-PjpDPi8BOaC_kEuVCysokU19lHFSTY-xzofgyFrE9rW1tBghMuBWUdPd0-X-NO0OJbaKkc" />
                            </a>
                            <div class="p-4">
                                <p class="text-xs text-text-light/60 dark:text-text-dark/60">Creative Kids</p>
                                <h3 class="font-bold text-lg mt-1"><a href="#">Magnetic Tile Set</a></h3>
                                <p class="font-bold text-primary mt-2">$59.99</p>
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-white dark:from-background-dark/80 to-transparent opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <button
                                    class="w-full bg-primary text-white font-bold py-2.5 rounded-lg text-sm transition-transform hover:scale-105">Add
                                    to Cart</button>
                            </div>
                        </div>
                        <!-- Product Card 6 -->
                        <div
                            class="group relative overflow-hidden rounded-xl bg-white dark:bg-background-dark/50 shadow-sm hover:shadow-xl transition-all duration-300 border border-stone-200 dark:border-stone-800">
                            <a class="block" href="#">
                                <img class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
                                    data-alt="Wooden animal-shaped stacking blocks"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5K52fTkWtzpwsDAWrmwo6ymHRVZligPRhdQCwaNxxWC2ehVWD1jQcnwnYcvennZw_gLp3aiJ4w0H0WT5NR_9XLvxUZirtrANNK_GPbmV_fyQb8TEYTI8KyLKRS9jL_UWdpeJOsVaPsybz4Wtwulro5MjG-Cn3Cz4jS7NpfGnTn10xzaCj19Hx7KdeU6q8FLSICafslXQrf-j--emW32hU46qpSjm6FQy2zWxDDlHxMYgq9VkeSXvTg_815_q985A_Q-GSluZ-Pj8" />
                            </a>
                            <div class="p-4">
                                <p class="text-xs text-text-light/60 dark:text-text-dark/60">Fun Times</p>
                                <h3 class="font-bold text-lg mt-1"><a href="#">Animal Stacker Blocks</a></h3>
                                <p class="font-bold text-primary mt-2">$22.50</p>
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-white dark:from-background-dark/80 to-transparent opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <button
                                    class="w-full bg-primary text-white font-bold py-2.5 rounded-lg text-sm transition-transform hover:scale-105">Add
                                    to Cart</button>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <nav class="flex items-center justify-center gap-2 mt-12">
                        <a class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 hover:bg-stone-300 dark:hover:bg-stone-700 transition-colors"
                            href="#">
                            <span class="material-symbols-outlined text-xl">chevron_left</span>
                        </a>
                        <a class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white font-bold text-sm"
                            href="#">1</a>
                        <a class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-stone-200 dark:hover:bg-stone-800 transition-colors font-bold text-sm"
                            href="#">2</a>
                        <a class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-stone-200 dark:hover:bg-stone-800 transition-colors font-bold text-sm"
                            href="#">3</a>
                        <span class="flex h-10 w-10 items-center justify-center font-bold text-sm">...</span>
                        <a class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-stone-200 dark:hover:bg-stone-800 transition-colors font-bold text-sm"
                            href="#">8</a>
                        <a class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 hover:bg-stone-300 dark:hover:bg-stone-700 transition-colors"
                            href="#">
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </main>
@endsection
