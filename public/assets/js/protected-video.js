(function () {
    function setStatus(player, message, type) {
        const status = player.querySelector('.protected-video-player__status');
        if (!status) {
            return;
        }

        status.textContent = message;
        status.className = 'protected-video-player__status';

        if (type) {
            status.classList.add('protected-video-player__status--' + type);
        }
    }

    function applyWatermark(player, label) {
        const watermark = player.querySelector('.protected-video-player__watermark');
        if (watermark && label) {
            watermark.setAttribute('data-label', label);
        }
    }

    function blockContextMenu(player) {
        player.addEventListener('contextmenu', function (event) {
            event.preventDefault();
        });

        const video = player.querySelector('.protected-video-player__video');
        if (video) {
            video.addEventListener('contextmenu', function (event) {
                event.preventDefault();
            });
        }
    }

    function clearLoadingStatus(player) {
        setStatus(player, '');
    }

    function attachPlaybackListeners(player, video) {
        video.addEventListener('loadeddata', function () {
            clearLoadingStatus(player);
            showControls(player);
        });

        video.addEventListener('error', function () {
            setStatus(player, 'تعذر تشغيل الفيديو. حاول تحديث الصفحة.', 'error');
        });
    }

    function createHlsConfig() {
        return {
            enableWorker: true,
            lowLatencyMode: false,
            xhrSetup: function (xhr, url) {
                // Signed GCS segment URLs must NOT send cookies — breaks CORS.
                try {
                    const target = new URL(url, window.location.href);
                    if (target.origin === window.location.origin) {
                        xhr.withCredentials = true;
                    }
                } catch (error) {
                    xhr.withCredentials = true;
                }
            },
        };
    }

    function destroyHls(instance) {
        if (instance) {
            instance.destroy();
        }
    }

    function playMp4(player, video, src, message) {
        destroyHls(player._hlsInstance);
        player._hlsInstance = null;

        if (message) {
            setStatus(player, message, 'processing');
        } else {
            setStatus(player, '');
        }

        video.src = src;
        attachPlaybackListeners(player, video);
    }

    function formatTime(seconds) {
        if (!isFinite(seconds) || seconds < 0) {
            return '0:00';
        }

        const total = Math.floor(seconds);
        const minutes = Math.floor(total / 60);
        const secs = total % 60;

        return minutes + ':' + String(secs).padStart(2, '0');
    }

    function showControls(player) {
        const controls = player.querySelector('.protected-video-player__controls');

        if (controls) {
            controls.hidden = false;
        }
    }

    function setupCustomControls(player) {
        const container = player.querySelector('.protected-video-player__container');
        const video = player.querySelector('.protected-video-player__video');
        const controls = player.querySelector('.protected-video-player__controls');
        const playBtn = player.querySelector('.protected-video-player__play-btn');
        const progress = player.querySelector('.protected-video-player__progress');
        const timeLabel = player.querySelector('.protected-video-player__time');

        if (!container || !video || !controls) {
            return;
        }

        let isSeeking = false;

        function updatePlayState() {
            container.classList.toggle('protected-video-player__container--playing', !video.paused && !video.ended);

            if (playBtn) {
                const label = video.paused ? 'تشغيل' : 'إيقاف مؤقت';
                playBtn.setAttribute('aria-label', label);
                playBtn.setAttribute('title', label);
            }
        }

        function updateProgress() {
            if (!progress || !video.duration || isSeeking) {
                return;
            }

            progress.value = String((video.currentTime / video.duration) * 100);
        }

        function updateTime() {
            if (!timeLabel) {
                return;
            }

            const current = formatTime(video.currentTime);
            const total = video.duration ? formatTime(video.duration) : '0:00';
            timeLabel.textContent = current + ' / ' + total;
        }

        function togglePlay() {
            if (video.paused || video.ended) {
                video.play().catch(function () {
                    // autoplay policies — user must interact again
                });
            } else {
                video.pause();
            }
        }

        if (playBtn) {
            playBtn.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                togglePlay();
            });
        }

        container.addEventListener('click', function (event) {
            if (event.target.closest('.protected-video-player__controls')) {
                return;
            }

            togglePlay();
        });

        if (progress) {
            progress.addEventListener('input', function () {
                isSeeking = true;

                if (video.duration) {
                    video.currentTime = (parseFloat(progress.value) / 100) * video.duration;
                    updateTime();
                }
            });

            progress.addEventListener('change', function () {
                isSeeking = false;
            });
        }

        video.addEventListener('play', updatePlayState);
        video.addEventListener('pause', updatePlayState);
        video.addEventListener('ended', updatePlayState);
        video.addEventListener('loadedmetadata', function () {
            showControls(player);
            updateTime();
            updateProgress();
        });
        video.addEventListener('timeupdate', function () {
            updateProgress();
            updateTime();
        });

        updatePlayState();
    }

    function blockNativeVideoFullscreen(video) {
        video.setAttribute('controls', 'false');
        video.removeAttribute('controls');

        video.addEventListener('webkitbeginfullscreen', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (video.webkitExitFullscreen) {
                video.webkitExitFullscreen();
            }
        }, true);

        if (video.webkitEnterFullscreen) {
            try {
                Object.defineProperty(video, 'webkitEnterFullscreen', {
                    value: function () {
                        return false;
                    },
                    writable: false,
                    configurable: true,
                });
            } catch (error) {
                // read-only on some browsers — webkitbeginfullscreen handler above is the fallback
            }
        }

        if (video.requestFullscreen) {
            const nativeRequest = video.requestFullscreen.bind(video);
            video.requestFullscreen = function () {
                return Promise.reject(new DOMException('Native video fullscreen is disabled.'));
            };
            video._nativeRequestFullscreen = nativeRequest;
        }
    }

    function getFullscreenElement() {
        return document.fullscreenElement
            || document.webkitFullscreenElement
            || document.msFullscreenElement
            || null;
    }

    function setupContainerFullscreen(player) {
        const container = player.querySelector('.protected-video-player__container');
        const video = player.querySelector('.protected-video-player__video');
        const fsBtn = player.querySelector('.protected-video-player__fs-btn');

        if (!container || !video) {
            return;
        }

        function isCustomFs() {
            return container.classList.contains('protected-video-player__container--custom-fs');
        }

        function isContainerFs() {
            return getFullscreenElement() === container || isCustomFs();
        }

        function updateFsButton() {
            if (!fsBtn) {
                return;
            }

            const active = isContainerFs();
            fsBtn.setAttribute('aria-pressed', active ? 'true' : 'false');
            fsBtn.setAttribute('aria-label', active ? 'الخروج من ملء الشاشة' : 'ملء الشاشة');
            fsBtn.setAttribute('title', active ? 'الخروج من ملء الشاشة' : 'ملء الشاشة');
        }

        function lockBody() {
            document.body.classList.add('protected-video-player-body-locked');
        }

        function unlockBody() {
            if (!document.querySelector('.protected-video-player__container--custom-fs')) {
                document.body.classList.remove('protected-video-player-body-locked');
            }
        }

        function enterCssFullscreen() {
            container.classList.add('protected-video-player__container--custom-fs');
            lockBody();
            updateFsButton();
        }

        function exitCssFullscreen() {
            container.classList.remove('protected-video-player__container--custom-fs');
            unlockBody();
            updateFsButton();
        }

        function requestContainerFullscreen() {
            const request = container.requestFullscreen
                || container.webkitRequestFullscreen
                || container.msRequestFullscreen;

            if (!request) {
                enterCssFullscreen();
                return Promise.resolve();
            }

            lockBody();

            return Promise.resolve(request.call(container)).catch(function () {
                enterCssFullscreen();
            }).finally(updateFsButton);
        }

        function exitContainerFullscreen() {
            exitCssFullscreen();

            const exit = document.exitFullscreen
                || document.webkitExitFullscreen
                || document.msExitFullscreen;

            if (exit && getFullscreenElement()) {
                Promise.resolve(exit.call(document)).finally(updateFsButton);
                return;
            }

            updateFsButton();
        }

        function toggleContainerFullscreen() {
            if (isContainerFs()) {
                exitContainerFullscreen();
            } else {
                requestContainerFullscreen();
            }
        }

        function redirectVideoFullscreenToContainer() {
            if (video.webkitExitFullscreen) {
                try {
                    video.webkitExitFullscreen();
                } catch (error) {
                    // ignore
                }
            }

            if (getFullscreenElement() === video && document.exitFullscreen) {
                document.exitFullscreen().catch(function () {
                    // ignore
                });
            }

            setTimeout(function () {
                if (!isContainerFs()) {
                    requestContainerFullscreen();
                }
            }, 50);
        }

        if (fsBtn) {
            fsBtn.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                toggleContainerFullscreen();
            });
        }

        document.addEventListener('fullscreenchange', function () {
            if (getFullscreenElement() === video) {
                redirectVideoFullscreenToContainer();
                return;
            }

            if (!getFullscreenElement() && !isCustomFs()) {
                unlockBody();
            }

            updateFsButton();
        });

        document.addEventListener('webkitfullscreenchange', function () {
            if (getFullscreenElement() === video) {
                redirectVideoFullscreenToContainer();
                return;
            }

            if (!getFullscreenElement() && !isCustomFs()) {
                unlockBody();
            }

            updateFsButton();
        });

        video.addEventListener('webkitbeginfullscreen', function () {
            redirectVideoFullscreenToContainer();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isContainerFs()) {
                exitContainerFullscreen();
            }
        });
    }

    function initProtectedPlayer(player) {
        if (player.dataset.playbackReady === '1') {
            return;
        }

        player.dataset.playbackReady = '1';

        const playbackUrl = player.dataset.playbackUrl;
        const video = player.querySelector('.protected-video-player__video');

        if (!playbackUrl || !video) {
            return;
        }

        blockContextMenu(player);
        blockNativeVideoFullscreen(video);
        setupCustomControls(player);
        setupContainerFullscreen(player);

        fetch(playbackUrl, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok) {
                        throw new Error(data.message || 'تعذر تحميل الفيديو');
                    }

                    return data;
                });
            })
            .then(function (data) {
                if (!data.success) {
                    throw new Error(data.message || 'تعذر تحميل الفيديو');
                }

                applyWatermark(player, data.watermark);

                if (data.type === 'processing' || (data.processing && !data.src)) {
                    setStatus(
                        player,
                        data.message || 'جاري تجهيز نسخة محمية من الفيديو... يُرجى المحاولة لاحقاً.',
                        'processing'
                    );
                    return;
                }

                if (data.legacy) {
                    setStatus(player, 'فيديو قديم — يُفضّل ربطه من مكتبة الفيديوهات للحماية الكاملة.', 'processing');
                } else if (data.processing) {
                    setStatus(
                        player,
                        data.message || 'جاري تجهيز نسخة محمية من الفيديو...',
                        'processing'
                    );
                } else {
                    setStatus(player, '');
                }

                if (!data.src) {
                    return;
                }

                if (data.type === 'hls') {
                    if (window.Hls && Hls.isSupported()) {
                        const hls = new Hls(createHlsConfig());

                        player._hlsInstance = hls;
                        hls.loadSource(data.src);
                        hls.attachMedia(video);
                        attachPlaybackListeners(player, video);
                        hls.on(Hls.Events.ERROR, function (event, errorData) {
                            if (!errorData.fatal) {
                                return;
                            }

                            console.error('HLS fatal error', errorData);

                            if (data.mp4_fallback) {
                                playMp4(
                                    player,
                                    video,
                                    data.mp4_fallback,
                                    'تعذر تشغيل النسخة المحمية — يتم التشغيل بالنسخة الأصلية مؤقتاً.'
                                );
                                return;
                            }

                            setStatus(player, 'حدث خطأ أثناء تشغيل الفيديو المحمي.', 'error');
                        });
                    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                        video.src = data.src;
                        attachPlaybackListeners(player, video);
                    } else if (data.mp4_fallback) {
                        playMp4(player, video, data.mp4_fallback);
                    } else {
                        throw new Error('المتصفح لا يدعم تشغيل الفيديو المحمي');
                    }
                } else {
                    playMp4(
                        player,
                        video,
                        data.src,
                        data.processing ? (data.message || 'جاري تجهيز نسخة محمية من الفيديو...') : ''
                    );
                }
            })
            .catch(function (error) {
                setStatus(player, error.message || 'تعذر تحميل الفيديو', 'error');
            });
    }

    function observeProtectedPlayers() {
        const players = document.querySelectorAll('.protected-video-player[data-playback-url]');

        if (!('IntersectionObserver' in window)) {
            players.forEach(initProtectedPlayer);
            return;
        }

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                initProtectedPlayer(entry.target);
                observer.unobserve(entry.target);
            });
        }, {
            root: null,
            rootMargin: '200px 0px',
            threshold: 0.1,
        });

        players.forEach(function (player) {
            observer.observe(player);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        observeProtectedPlayers();
    });

    window.addEventListener('beforeunload', function () {
        document.querySelectorAll('.protected-video-player').forEach(function (player) {
            destroyHls(player._hlsInstance);
        });
    });
})();
