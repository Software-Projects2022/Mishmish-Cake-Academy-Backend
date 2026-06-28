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
                    setStatus(player, 'جاري تجهيز نسخة محمية من الفيديو...', 'processing');
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
                            if (errorData.fatal) {
                                console.error('HLS fatal error', errorData);
                                setStatus(player, 'حدث خطأ أثناء تشغيل الفيديو المحمي.', 'error');
                            }
                        });
                    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                        video.src = data.src;
                        attachPlaybackListeners(player, video);
                    } else {
                        throw new Error('المتصفح لا يدعم تشغيل الفيديو المحمي');
                    }
                } else {
                    video.src = data.src;
                    attachPlaybackListeners(player, video);
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
