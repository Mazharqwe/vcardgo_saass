( function( $ ) {
    var pxl_widget_image_handler = function( $scope, $ ) {
        /* Image Effect */
        if($('.pxl-image-tilt').length) {
            $('.pxl-image-tilt').each(function () {
                var $this = $(this);
                VanillaTilt.init($this[0], {
                    max: 3,
                    speed: 1000,
                    glare: false,
                    "max-glare": 0.5,
                    perspective: 1400,
                    easing: "cubic-bezier(.03, .98, .52, .99)",
                    reset: true
                });
            });
        }

        /* Ink Transition Effect */
        const inkTriggers = [...document.querySelectorAll('.pxl-image-ink')];
        const pxl_controller = new ScrollMagic.Controller();
        inkTriggers.map(ink => {
            const sceneInk = new ScrollMagic.Scene({
                triggerElement: ink,
                triggerHook: 'onEnter',
            })
            .setClassToggle(ink, 'is-active')
            .reverse(false)
            .addTo(pxl_controller);
        });

        /* Scroll Load Effect */
        const imagesAni = document.querySelectorAll(".pxl-image-scroller img");
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.filter = "grayscale(0)";
                    } else {
                        entry.target.style.opacity = 0;
                        entry.target.style.filter = "grayscale(1)";
                    }
                });
            },
            {
                threshold: 0.15
            }
            );
        imagesAni.forEach((el, i) => {
            observer.observe(el);
        });

    };

    var pxl_widget_text_image = function( $scope, $ ) {
        if($scope.find('.pxl-text-img-wrap').length <= 0) return;
        var mouseX = 0,
        mouseY = 0;

        $scope.find('.pxl-text-img-wrap .pxl-item--inner').mousemove(function(e){
            var offset = $(this).offset();
            mouseX = (e.pageX - offset.left);
            mouseY = (e.pageY - offset.top);
        });

        $scope.find('.pxl-text-img-wrap ul>li').on("mouseenter", function() {
            $(this).removeClass('deactive').addClass('active');
            var target = $(this).attr('data-target');
            $(this).closest('.pxl-item--inner').find(target).removeClass('deactive').addClass('active');
        });
        $scope.find('.pxl-text-img-wrap ul>li').on("mouseleave", function() {
            $(this).addClass('deactive').removeClass('active');
            var target = $(this).attr('data-target');
            $(this).closest('.pxl-item--inner').find(target).addClass('deactive').removeClass('active');
        });
        const s = {
            x: window.innerWidth / 2,
            y: window.innerHeight / 2
        },
        t = gsap.quickSetter($scope.find('.pxl-text-img-wrap .pxl-item--inner'), "css"),
        e = gsap.quickSetter($scope.find('.pxl-text-img-wrap .pxl-item--inner'), "css");

        gsap.ticker.add((() => {
            const o = .15,
            i = 1 - Math.pow(.85, gsap.ticker.deltaRatio());
            s.x += (mouseX - s.x) * i,
            s.y += (mouseY - s.y) * i,
            t({
                "--pxl-mouse-x": `${s.x}px`
            }), e({
                "--pxl-mouse-y": `${s.y}px`
            })
        }))
    };

    var pxl_widget_button_handler = function( $scope, $ ) {
        /* Button Effect */
        var wobbleElements = document.querySelectorAll('.pxl-wobble');
        wobbleElements.forEach(function(el){
            el.addEventListener('mouseover', function(){
                if(!el.classList.contains('animating') && !el.classList.contains('mouseover')){
                    el.classList.add('animating','mouseover');
                    var letters = el.innerText.split('');
                    setTimeout(function(){ el.classList.remove('animating'); }, (letters.length + 1) * 50);
                    var animationName = el.dataset.animation;
                    if(!animationName){ animationName = "pxl-jump"; }
                    el.innerText = '';
                    letters.forEach(function(letter){
                        if(letter == " "){
                            letter = "&nbsp;";
                        }
                        el.innerHTML += '<span class="letter">'+letter+'</span>';
                    });
                    var letterElements = el.querySelectorAll('.letter');
                    letterElements.forEach(function(letter, i){
                        setTimeout(function(){
                            letter.classList.add(animationName);
                        }, 50 * i);
                    });
                }
            });
            el.addEventListener('mouseout', function(){
                el.classList.remove('mouseover');
            });
        });

    };

    var pxl_gsap_ani = function( $scope, $ ) {
        gsap.registerPlugin(SplitText, ScrollTrigger);

        // SplitText
        var st = $scope.find(".pxl-split-text");
        // if(st.length == 0) return;
        st.each(function(index, el) {
            el.split = new SplitText(el, {
                type: "lines,words,chars",
                linesClass: "split-line"
            });
            gsap.set(el, { perspective: 400 });

            if( $(el).hasClass('split-in-fade') ){
                gsap.set(el.split.chars, {
                    opacity: 0,
                    ease: "Back.easeOut",
                });
            }
            if( $(el).hasClass('split-in-right') ){
                gsap.set(el.split.chars, {
                    opacity: 0,
                    x: "50",
                    ease: "Back.easeOut",
                });
            }
            if( $(el).hasClass('split-in-left') ){
                gsap.set(el.split.chars, {
                    opacity: 0,
                    x: "-50",
                    ease: "circ.out",
                });
            }
            if( $(el).hasClass('split-in-up') ){
                gsap.set(el.split.chars, {
                    opacity: 0,
                    y: "80",
                    ease: "circ.out",
                });
            }
            if( $(el).hasClass('split-in-down') ){
                gsap.set(el.split.chars, {
                    opacity: 0,
                    y: "-80",
                    ease: "circ.out",
                });
            }
            if( $(el).hasClass('split-in-rotate') ){
                gsap.set(el.split.chars, {
                    opacity: 0,
                    rotateX: "50deg",
                    ease: "circ.out",
                });
            }
            if( $(el).hasClass('split-in-scale') ){
                gsap.set(el.split.chars, {
                    opacity: 0,
                    scale: "0.5",
                    ease: "circ.out",
                });
            }
            el.anim = gsap.to(el.split.chars, {
                scrollTrigger: {
                    trigger: el,
                    toggleActions: "restart pause resume reverse",
                    start: "top 90%",
                },
                x: "0",
                y: "0",
                rotateX: "0",
                scale: 1,
                opacity: 1,
                duration: 0.8,
                stagger: 0.02,
            });
        });

        // ScrollTrigger
        const scrollEx = () => {
            document.body.style.overflow = 'auto';
            var prevSection = $scope.prev('section');
            gsap.utils.toArray($scope.find('.element-scroll')).forEach((section, index) => {
                const w = section;
                var x = w.scrollWidth * -1;
                var xEnd = 0;
                if($(section).closest('.pxl-section-scroll').hasClass('revesal')){
                    x = '100%';
                    xEnd = (w.scrollWidth + 50 - section.offsetWidth) * -1;
                }
                gsap.fromTo(w, { x }, {
                    x: xEnd,
                    scrollTrigger: {
                        trigger: prevSection,
                        start: 'top 10%',
                        end: 'bottom 50%',
                        scrub: 0.5
                    }
                });
            });
        }
        scrollEx();

    };

    var pxl_widget_image_box_handler = function( $scope, $ ) {
        if (window.elementorFrontend.isEditMode()) {
            class WebglHover {
                constructor(set) {
                    this.canvas = set.canvas
                    this.webGLCurtain = new Curtains({
                        container: this.canvas,
                        watchScroll: false,
                        pixelRatio: Math.min(1.5, window.devicePixelRatio)
                    })
                    this.planeElement = set.planeElement
                    this.mouse = {
                        x: 0,
                        y: 0
                    }
                    this.params = {
                        vertexShader: document.getElementById("pxl-imb1-vs").textContent,
                        fragmentShader: document.getElementById("pxl-imb1-fs").textContent,
                        widthSegments: 40,
                        heightSegments: 40,
                        uniforms: {
                            time: {
                                name: "uTime",
                                type: "1f",
                                value: 0
                            },
                            mousepos: {
                                name: "uMouse",
                                type: "2f",
                                value: [0, 0]
                            },
                            resolution: {
                                name: "uReso",
                                type: "2f",
                                value: [innerWidth, innerHeight]
                            },
                            progress: {
                                name: "uProgress",
                                type: "1f",
                                value: 0
                            }
                        }
                    }
                    this.initPlane()
                }

                initPlane() {
                    this.plane = new Plane(this.webGLCurtain, this.planeElement, this.params)

                    if (this.plane) {
                        this.plane.onReady(() => {
                            this.update()
                            this.initEvent()
                        })
                    }
                }

                update() {
                    this.plane.onRender(() => {
                        this.plane.uniforms.time.value += 0.01

                        this.plane.uniforms.resolution.value = [innerWidth, innerHeight]
                    })
                }

                initEvent() {
                    this.planeElement.addEventListener("mouseenter", () => {
                        gsap.to(this.plane.uniforms.progress, .8, {
                            value: 1
                        })
                    })

                    this.planeElement.addEventListener("mouseout", () => {
                        gsap.to(this.plane.uniforms.progress, .8, {
                            value: 0
                        })
                    })
                }
            }

            $(window).on('scroll', function () {
                if (navigator.userAgent.indexOf('Safari') == -1 || navigator.userAgent.indexOf('Chrome') > -1) {
                    $('.pxl-image-box1, .pxl-image-box3').each(function() {
                        const $this = $(this);
                        const item_image_height = $this.find('.image-front').height();
                        $this.find('.canvas canvas').css('height', item_image_height + 'px');

                        const initialized = $this.data('initialized');
                        if (!initialized) {
                            $this.data('initialized', true);
                            const canvas = $this.find('.canvas')[0];
                            const planeElement = $this.find('.item--image')[0];
                            new WebglHover({
                                canvas: canvas,
                                planeElement: planeElement
                            });
                        }
                    });
                }

                if (/^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
                    $('.pxl-image-box1 .image-front, .pxl-image-box3 .image-front').css('opacity', '1');
                }

            });

        }
    };

    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/pxl_heading.default', pxl_gsap_ani );
    } );
} )( jQuery );