    <script>
        const cursorDot = document.querySelector('.cursor-dot');
        const cursorOutline = document.querySelector('.cursor-outline');
        const cursorRipple = document.querySelector('.cursor-ripple');

        if (window.matchMedia("(min-width: 1024px)").matches) {
            window.addEventListener('mousemove', function(e) {
                const posX = e.clientX; const posY = e.clientY;
                cursorDot.style.left = `${posX}px`; cursorDot.style.top = `${posY}px`;
                cursorRipple.style.left = `${posX}px`; cursorRipple.style.top = `${posY}px`;
                cursorOutline.animate({ left: `${posX}px`, top: `${posY}px` }, { duration: 500, fill: "forwards" });
            });
            const interactiveElements = document.querySelectorAll('a, button, input, textarea');
            interactiveElements.forEach(el => {
                el.addEventListener('mouseenter', () => document.body.classList.add('hovering'));
                el.addEventListener('mouseleave', () => document.body.classList.remove('hovering'));
            });
            const nativeAreas = document.querySelectorAll('.native-cursor-area');
            nativeAreas.forEach(area => {
                area.addEventListener('mouseenter', () => {
                    cursorDot.classList.add('cursor-hidden');
                    cursorOutline.classList.add('cursor-hidden');
                    cursorRipple.classList.add('cursor-hidden');
                });
                area.addEventListener('mouseleave', () => {
                    cursorDot.classList.remove('cursor-hidden');
                    cursorOutline.classList.remove('cursor-hidden');
                    cursorRipple.classList.remove('cursor-hidden');
                });
            });
        }

        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');
        const mobileLinks = document.querySelectorAll('.mobile-link');
        let isOpen = false;

        function closeMenu() {
            isOpen = false;
            menu.classList.remove('max-h-screen', 'opacity-100');
            menu.classList.add('max-h-0', 'opacity-0');
            btn.classList.remove('rotate-90');
            icon.classList.remove('fa-xmark'); icon.classList.add('fa-bars');
        }

        btn.addEventListener('click', () => {
            isOpen = !isOpen;
            if (isOpen) {
                menu.classList.remove('max-h-0', 'opacity-0');
                menu.classList.add('max-h-screen', 'opacity-100');
                btn.classList.add('rotate-90');
                icon.classList.remove('fa-bars'); icon.classList.add('fa-xmark');
            } else { closeMenu(); }
        });

        mobileLinks.forEach(link => link.addEventListener('click', closeMenu));
        document.addEventListener('click', (e) => { if (isOpen && !btn.contains(e.target) && !menu.contains(e.target)) closeMenu(); });
    </script>
