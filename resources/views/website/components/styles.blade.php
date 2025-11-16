<link href="https://fonts.googleapis.com" rel="preconnect" />
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;display=swap"
    rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<style>
    /* Page Loader Styles */
    #page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #FDFBF6;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
    }

    #page-loader.dark {
        background: #101c22;
    }

    #page-loader.hidden {
        opacity: 0;
        visibility: hidden;
    }

    .loader-dots {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        justify-content: center;
    }

    .loader-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #42b6f0;
        animation: dot-bounce 1.4s ease-in-out infinite;
    }

    .loader-dot:nth-child(1) {
        animation-delay: 0s;
    }

    .loader-dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .loader-dot:nth-child(3) {
        animation-delay: 0.4s;
    }

    #page-loader.dark .loader-dot {
        background-color: #42b6f0;
    }

    @keyframes dot-bounce {

        0%,
        80%,
        100% {
            transform: scale(0.8);
            opacity: 0.5;
        }

        40% {
            transform: scale(1.2);
            opacity: 1;
        }
    }

    .loader-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .loader-text {
        color: #4A4A4A;
        font-size: 0.875rem;
        font-weight: 500;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    #page-loader.dark .loader-text {
        color: #f6f7f8;
    }

    /* Custom Scrollbar Styles */
    /* Webkit browsers (Chrome, Safari, Edge) */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f6f7f8;
        border-radius: 10px;
    }

    .dark ::-webkit-scrollbar-track {
        background: #101c22;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #42b6f0 0%, #2a9dd4 50%, #1e8bc0 100%);
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: padding-box;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #2a9dd4 0%, #1e8bc0 50%, #1578a3 100%);
        background-clip: padding-box;
    }

    /* Firefox */
    * {
        scrollbar-width: thin;
        scrollbar-color: #42b6f0 #f6f7f8;
    }

    .dark * {
        scrollbar-color: #42b6f0 #101c22;
    }
</style>
