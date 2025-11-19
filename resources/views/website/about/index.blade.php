@extends('website.layout.app')

@section('title', 'About')

@section('contents')
    <main class="flex flex-1 justify-center py-5 sm:py-10">
        <div class="flex flex-col flex-1 px-4 sm:px-6">
            {{-- Start Hero Section --}}
            <div class="@container px-0 sm:px-4">
                <div class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-xl items-center justify-center p-6 text-center"
                    data-alt="Modern ecommerce platform showcasing quality products"
                    style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuA1w4iGa2zzCjhCUPzZ1PWj0__7d8l4NpqfcsiENSKthMs78YJqgtNxwD2FWbYQaUmiJf_L7drj3bAmRmq03L1M7ZHPEk0o_9DbuAPbS-ML4g2oyfzDWSJI8X7xU_a_ZfOBC0DJgf27PgWIPUN3bT0KPOjiGu30rVgGCwjTe0tkXLoi8jdmTf-bdXsTcsqCWpg7ocFGHT4fcdSGnHA4PvHFeplbPdfFnPy58DF_d7REA3aXbQxi6mnHm6tik0opLjZAXJD0Wf0nyLI");'>
                    <div class="flex flex-col gap-2">
                        <h1
                            class="text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]">
                            Our Story
                        </h1>
                        <h2
                            class="text-white/90 text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal max-w-2xl mx-auto">
                            We are committed to providing high-quality products with exceptional customer service and
                            sustainable business practices.
                        </h2>
                    </div>
                    <button
                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-primary text-[#181411] text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em] hover:brightness-110 transition-all">
                        <span class="truncate">Shop Our Collections</span>
                    </button>
                </div>
            </div>
            {{-- End Hero Section --}}
            {{-- Start From Our Family to Yours Section --}}
            <div class="mt-12 sm:mt-20">
                <h2
                    class="text-[#181411] dark:text-background-light text-2xl sm:text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 text-center">
                    About Us</h2>
                <div class="p-4">
                    <div
                        class="flex flex-col md:flex-row items-center justify-between gap-8 rounded-xl bg-white/50 dark:bg-black/20 p-6 md:p-8">
                        <div class="w-full md:w-1/3 bg-center bg-no-repeat aspect-square md:aspect-[4/5] bg-cover rounded-xl"
                            data-alt="Professional business portrait"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCZk0lUkcI3HnvCaqDiq_WnQWqgmCkGPDpTh6hUncU6Xy-3voiQn9IERqpQShorc0EnBoGd1PhKnNqpe6mvZ0BbhUXrh2HFDFZo3aUoyXWyeT1Bk4oXw9E2BvocLOQG_TlNvsSU7xS-mWU4y2oAF5TbXlgYgoLfmtRP6a9KAD7G-zTxYKATBTuoL21Q2x8c9-eoGR7-y4OVW1UvRzFDgr7J8umP8MCWlmrXN0QRbDR5e_awxOxmxPvDstsOEgq9ZZsmqSA9MtCHXnI");'>
                        </div>
                        <div class="flex flex-1 flex-col gap-4 text-center md:text-left">
                            <div class="flex flex-col gap-1">
                                <p class="text-[#181411] dark:text-background-light text-xl font-bold leading-tight">Our
                                    Founder's Story</p>
                                <p class="text-[#897561] dark:text-gray-400 text-base font-normal leading-relaxed">
                                    It all started with a simple idea: to create a platform that offers high-quality
                                    products at competitive prices. We wanted to build a business that prioritizes customer
                                    satisfaction and sustainable practices. We carefully select every product in our
                                    catalog, ensuring it meets our standards for quality, value, and reliability.
                                </p>
                            </div>
                            <button
                                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-black/5 dark:bg-white/5 text-[#181411] dark:text-background-light text-sm font-medium leading-normal w-fit self-center md:self-start hover:bg-black/10 dark:hover:bg-white/10 transition-colors">
                                <span class="truncate">Read More</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End From Our Family to Yours Section --}}
            {{-- Start Our Core Values Section --}}
            <div class="mt-12 sm:mt-20">
                <h2
                    class="text-[#181411] dark:text-background-light text-2xl sm:text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-5 pt-5 text-center">
                    Our Core Values</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-4">
                    <div
                        class="flex flex-col items-center text-center p-6 bg-white/50 dark:bg-black/20 rounded-xl gap-3 transition-transform hover:-translate-y-2">
                        <div class="flex items-center justify-center size-16 bg-primary/20 rounded-full text-primary mb-2">
                            <span class="material-symbols-outlined text-4xl">health_and_safety</span>
                        </div>
                        <h3 class="text-lg font-bold">Quality Assurance</h3>
                        <p class="text-sm text-[#897561] dark:text-gray-400 leading-relaxed">Every product is carefully
                            selected and tested to meet our high quality standards. Your satisfaction is our top priority.
                        </p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center p-6 bg-white/50 dark:bg-black/20 rounded-xl gap-3 transition-transform hover:-translate-y-2">
                        <div class="flex items-center justify-center size-16 bg-primary/20 rounded-full text-primary mb-2">
                            <span class="material-symbols-outlined text-4xl">eco</span>
                        </div>
                        <h3 class="text-lg font-bold">Sustainability</h3>
                        <p class="text-sm text-[#897561] dark:text-gray-400 leading-relaxed">We are committed to
                            sustainability, using eco-friendly materials and packaging whenever possible to minimize our
                            environmental impact.</p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center p-6 bg-white/50 dark:bg-black/20 rounded-xl gap-3 transition-transform hover:-translate-y-2">
                        <div class="flex items-center justify-center size-16 bg-primary/20 rounded-full text-primary mb-2">
                            <span class="material-symbols-outlined text-4xl">emoji_objects</span>
                        </div>
                        <h3 class="text-lg font-bold">Innovation</h3>
                        <p class="text-sm text-[#897561] dark:text-gray-400 leading-relaxed">We continuously seek out
                            innovative products and solutions to meet the evolving needs of our customers.</p>
                    </div>
                </div>
            </div>
            {{-- End Our Core Values Section --}}
            {{-- Start Our Journey Section --}}
            <div class="mt-12 sm:mt-20">
                <h2
                    class="text-[#181411] dark:text-background-light text-2xl sm:text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-5 pt-5 text-center">
                    Our Journey</h2>
                <div class="relative p-4 md:p-10">
                    <div class="absolute left-1/2 top-0 h-full w-1 -translate-x-1/2 bg-primary/20 rounded-full"></div>
                    <div class="relative flex flex-col gap-12">
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse">
                            <div class="md:w-1/2 md:pr-8">
                                <div class="bg-white/50 dark:bg-black/20 p-6 rounded-xl shadow-md">
                                    <p class="text-sm font-semibold text-primary">January 2021</p>
                                    <h3 class="text-lg font-bold mt-1">The Beginning</h3>
                                    <p class="text-sm text-[#897561] dark:text-gray-400 mt-2">Our company was founded with a
                                        vision to provide quality products and exceptional service to customers worldwide.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 -translate-x-1/2 -translate-y-4 md:translate-y-0 bg-background-light dark:bg-background-dark p-2 rounded-full">
                                <div
                                    class="flex items-center justify-center size-12 bg-[#fce9d3] dark:bg-primary/20 rounded-full text-primary text-3xl">
                                    <span class="material-symbols-outlined">lightbulb</span>
                                </div>
                            </div>
                            <div class="hidden md:block w-1/2"></div>
                        </div>
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse">
                            <div class="md:w-1/2 md:pl-8">
                                <div class="bg-white/50 dark:bg-black/20 p-6 rounded-xl shadow-md">
                                    <p class="text-sm font-semibold text-[#72c4b0]">August 2021</p>
                                    <h3 class="text-lg font-bold mt-1">First Product Launch</h3>
                                    <p class="text-sm text-[#897561] dark:text-gray-400 mt-2">We launched our first product
                                        line, carefully curated to meet the highest standards of quality and value.</p>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 -translate-x-1/2 -translate-y-4 md:translate-y-0 bg-background-light dark:bg-background-dark p-2 rounded-full">
                                <div
                                    class="flex items-center justify-center size-12 bg-[#e3f4f0] dark:bg-[#72c4b0]/20 rounded-full text-[#72c4b0] text-3xl">
                                    <span class="material-symbols-outlined">construction</span>
                                </div>
                            </div>
                            <div class="hidden md:block w-1/2"></div>
                        </div>
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse">
                            <div class="md:w-1/2 md:pr-8">
                                <div class="bg-white/50 dark:bg-black/20 p-6 rounded-xl shadow-md">
                                    <p class="text-sm font-semibold text-[#8eb8f2]">May 2022</p>
                                    <h3 class="text-lg font-bold mt-1">Online Store Launch</h3>
                                    <p class="text-sm text-[#897561] dark:text-gray-400 mt-2">We launched our online store,
                                        making our products accessible to customers worldwide with fast and reliable
                                        shipping.</p>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 -translate-x-1/2 -translate-y-4 md:translate-y-0 bg-background-light dark:bg-background-dark p-2 rounded-full">
                                <div
                                    class="flex items-center justify-center size-12 bg-[#dbe9fa] dark:bg-[#8eb8f2]/20 rounded-full text-[#8eb8f2] text-3xl">
                                    <span class="material-symbols-outlined">storefront</span>
                                </div>
                            </div>
                            <div class="hidden md:block w-1/2"></div>
                        </div>
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse">
                            <div class="md:w-1/2 md:pl-8">
                                <div class="bg-white/50 dark:bg-black/20 p-6 rounded-xl shadow-md">
                                    <p class="text-sm font-semibold text-primary">March 2024</p>
                                    <h3 class="text-lg font-bold mt-1">50,000+ Customers</h3>
                                    <p class="text-sm text-[#897561] dark:text-gray-400 mt-2">We reached a significant
                                        milestone, having served over 50,000 satisfied customers and counting!</p>
                                </div>
                            </div>
                            <div
                                class="absolute left-1/2 -translate-x-1/2 -translate-y-4 md:translate-y-0 bg-background-light dark:bg-background-dark p-2 rounded-full">
                                <div
                                    class="flex items-center justify-center size-12 bg-primary/20 dark:bg-primary/20 rounded-full text-primary text-3xl">
                                    <span class="material-symbols-outlined">celebration</span>
                                </div>
                            </div>
                            <div class="hidden md:block w-1/2"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Our Journey Section --}}
            {{-- Start Our Journey & Impact Section --}}
            <div class="mt-12 sm:mt-20">
                <h2
                    class="text-[#181411] dark:text-background-light text-2xl sm:text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-5 pt-5 text-center">
                    Our Journey &amp; Impact</h2>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div
                            class="flex flex-col items-center text-center p-6 bg-white/50 dark:bg-black/20 rounded-xl gap-4">
                            <h3 class="text-lg font-bold">Customers Served</h3>
                            <div
                                class="flex items-center justify-center w-full max-w-xs aspect-square rounded-full bg-[#fce9d3] dark:bg-primary/20 p-4">
                                <div
                                    class="flex flex-col items-center justify-center text-center size-full rounded-full bg-background-light dark:bg-[#342719] shadow-inner">
                                    <span class="material-symbols-outlined text-5xl text-primary">groups</span>
                                    <p class="text-4xl font-extrabold text-[#181411] dark:text-background-light mt-1">
                                        50,000+</p>
                                    <p class="text-sm text-[#897561] dark:text-gray-400">And growing every day!</p>
                                </div>
                            </div>
                            <p class="text-sm text-[#897561] dark:text-gray-400 leading-relaxed max-w-sm">We're honored to
                                serve customers worldwide, providing quality products and exceptional service.</p>
                        </div>
                        <div class="flex flex-col items-start p-6 bg-white/50 dark:bg-black/20 rounded-xl gap-6">
                            <h3 class="text-lg font-bold text-center w-full">Our Growth Story</h3>
                            <div class="w-full flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-sm text-[#897561] dark:text-gray-400">2021</span>
                                    <div class="w-full bg-[#fce9d3] dark:bg-primary/20 rounded-full h-6">
                                        <div class="bg-[#f8c387] h-6 rounded-full" style="width: 25%"></div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-sm text-[#897561] dark:text-gray-400">2022</span>
                                    <div class="w-full bg-[#e3f4f0] dark:bg-[#72c4b0]/20 rounded-full h-6">
                                        <div class="bg-[#72c4b0] h-6 rounded-full" style="width: 50%"></div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-sm text-[#897561] dark:text-gray-400">2023</span>
                                    <div class="w-full bg-[#dbe9fa] dark:bg-[#8eb8f2]/20 rounded-full h-6">
                                        <div class="bg-[#8eb8f2] h-6 rounded-full" style="width: 75%"></div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-sm text-[#897561] dark:text-gray-400">2024</span>
                                    <div class="w-full bg-primary/20 dark:bg-primary/20 rounded-full h-6">
                                        <div class="bg-primary h-6 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-[#897561] dark:text-gray-400 leading-relaxed text-center w-full">Each
                                bar represents a year of growth, innovation, and expanding our product catalog. Thank you
                                for being part of our journey!</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Our Journey & Impact Section --}}
            {{-- Start Meet the Team Section --}}
            <div class="mt-12 sm:mt-20">
                <h2
                    class="text-[#181411] dark:text-background-light text-2xl sm:text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-5 pt-5 text-center">
                    Meet the Team</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 p-4">
                    <div class="flex flex-col items-center text-center gap-3">
                        <div class="size-32 rounded-full bg-cover bg-center" data-alt="Team member Jane Doe"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCKL_z1apFOKS1nPdLUBEi6bPp9qblD5asWkg5pr2hGzhFi6DFNP0ZJMjp6GmET6ht8lG2bLpLITyMeGMsgyLj4fxOy-SqLf_fyEQGYc2E0wPWxQhck7WyJRnbKo-IRqreNWLziy4L17s3lvSgVHDwD5tU47Z6fS9S7oh_r1YHYttiokwjGmDXWaD3P3HooLayv61VbDJiRZA5rDjEICLsRSMSltu4WgEwIdTiZZ-7ziIZXaBubjZjFhGa56SbSonOMoOr23rboOzM')">
                        </div>
                        <h3 class="font-bold text-base">Jane Doe</h3>
                        <p class="text-sm text-[#897561] dark:text-gray-400">Founder &amp; CEO</p>
                    </div>
                    <div class="flex flex-col items-center text-center gap-3">
                        <div class="size-32 rounded-full bg-cover bg-center" data-alt="Team member John Smith"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBTgLH1oOU00VyKfmnTxdpgW8hY2D7bnaQ28Hu1t5qfeYzS_tMrjSN2EgETFE-QFvEcTprDDTmqizYKS3NMtEOrvxVaGoiGVkhnqPXrtNNOY0q2PB5FDW_pV93JkQNqmSulawZ_Ycqb7HIIsp0mpQSl4nP4UyEhi9eOqJgzg_C2GrnVdi-dEknjoFIriCLhC4TJ6ozMVStwohp4YhoRBaJtzl5zP9oYinU18bix95nBA9QeB321KXBcHNRwFpde7jdliBJLgtpeuhY')">
                        </div>
                        <h3 class="font-bold text-base">John Smith</h3>
                        <p class="text-sm text-[#897561] dark:text-gray-400">Lead Designer</p>
                    </div>
                    <div class="flex flex-col items-center text-center gap-3">
                        <div class="size-32 rounded-full bg-cover bg-center" data-alt="Team member Emily White"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDyPnQjDNV5wFqQNjlt4dKyEU4tTMhVe9Xe5FgtmuBuZ3BqMC3TXjIHKl39ZXZJN18tsS48nfRlMnRL79lbVeSM62vNHiSUqhCJgweb5kXnaLF-D0YgyBzesb_6E6O91hgYeFL__J1UfJB0p4_sM16WaiEGFZquwHfkBOKP9hba8IKSL4E3gOlWc3UyZpVUFUQPQtxNUY9ZAGw8T9hR5ARBtFH-WUOQ4IFsWnpWNA8_Mc8g2h6AdrrA1lCe9oXGvEM8NdGwlbE22Fo')">
                        </div>
                        <h3 class="font-bold text-base">Emily White</h3>
                        <p class="text-sm text-[#897561] dark:text-gray-400">Product Manager</p>
                    </div>
                    <div class="flex flex-col items-center text-center gap-3">
                        <div class="size-32 rounded-full bg-cover bg-center" data-alt="Team member Michael Brown"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAfflfGKSjHyePEPG-s_S5wL9vFJ60xjbnLGLAkL3j6a6fAaWb0UjtO1tBC32JobtDyqYmhL_dpEp3PS2iOCZVMUH6XZ1ryEKkz57ykJEKSqxI9CL-W8UxCDfUrMImBRsQXqMeTsaKf1DSrNaeLL94LmSEDbxNSuvzOKGXLWPfaToatW1lujRHDqpBQIRuKM0oADAs-VzTQ6KtGo8JiqSm4KC2m9pB-XX0vqGEFksI-NX80GVkRDinMdTDLmCmmKgXrQyhrrCFKN1M')">
                        </div>
                        <h3 class="font-bold text-base">Michael Brown</h3>
                        <p class="text-sm text-[#897561] dark:text-gray-400">Marketing Head</p>
                    </div>
                </div>
            </div>
            {{-- End Meet the Team Section --}}
            {{-- Start Join Our Community Section --}}
            <div class="mt-12 sm:mt-20">
                <div class="p-4">
                    <div
                        class="flex flex-col items-center justify-center text-center gap-6 p-10 bg-primary/20 dark:bg-primary/30 rounded-xl">
                        <h2 class="text-2xl sm:text-3xl font-bold text-[#181411] dark:text-background-light">Join Us</h2>
                        <p class="text-[#897561] dark:text-background-light/80 max-w-lg">
                            Explore our latest collections and discover quality products that meet your needs. Start
                            shopping today!
                        </p>
                        <button
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-5 bg-primary text-[#181411] text-base font-bold leading-normal tracking-[0.015em] hover:brightness-110 transition-all">
                            <span class="truncate">Explore Our Products</span>
                        </button>
                    </div>
                </div>
            </div>
            {{-- End Join Our Community Section --}}
        </div>
    </main>
@endsection
