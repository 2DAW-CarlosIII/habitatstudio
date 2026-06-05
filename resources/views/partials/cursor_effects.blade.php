        /* --- GOLDEN CUSTOM CURSOR --- */
        @media (min-width: 1024px) {
            *, *::before, *::after { cursor: none !important; }

            .cursor-hidden {
                opacity: 0 !important;
                visibility: hidden !important;
                animation: none !important;
                transition: opacity 0.2s ease;
            }

            .cursor-dot {
                position: fixed; top: 0; left: 0; width: 16px; height: 16px;
                background-color: #f59e0b;
                border-radius: 50%; pointer-events: none; z-index: 9999;
                transform: translate(-50%, -50%);
                box-shadow: 0 0 15px rgba(245, 158, 11, 0.6);
                transition: opacity 0.2s;
            }

            .cursor-outline {
                position: fixed; top: 0; left: 0; width: 32px; height: 32px;
                border: 2px solid #fbbf24; border-radius: 50%; pointer-events: none;
                z-index: 9998; transform: translate(-50%, -50%); opacity: 0.8;
                transition: width 0.2s, height 0.2s, background-color 0.2s, opacity 0.2s;
            }

            .cursor-ripple {
                position: fixed; top: 0; left: 0; width: 32px; height: 32px;
                border: 1px solid #fcd34d; border-radius: 50%; pointer-events: none;
                z-index: 9997; transform: translate(-50%, -50%);
                animation: pulse-animation 1.5s infinite ease-out;
                transition: opacity 0.2s;
            }

            @keyframes pulse-animation {
                0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
                100% { transform: translate(-50%, -50%) scale(2.2); opacity: 0; }
            }

            body.hovering .cursor-dot { transform: translate(-50%, -50%) scale(1.2); background-color: #d97706; }
            body.hovering .cursor-outline { width: 50px; height: 50px; background-color: rgba(245, 158, 11, 0.15); border-color: #d97706; }
            body.hovering .cursor-ripple { border-color: #d97706; }
        }
