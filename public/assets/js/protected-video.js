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

    function destroyHls(instance) {
        if (instance) {
            instance.destroy();
        }
    }

    function initProtectedPlayer(player) {
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

                if (data.processing) {
                    setStatus(player, 'جاري تجهيز نسخة محمية من الفيديو... سيتم التشغيل مؤقتاً بالنسخة الأصلية.', 'processing');
                } else {
                    setStatus(player, '');
                }

                if (data.type === 'hls') {
                    if (window.Hls && Hls.isSupported()) {
                        const hls = new Hls({
                            enableWorker: true,
                            lowLatencyMode: false,
                        });

                        player._hlsInstance = hls;
                        hls.loadSource(data.src);
                        hls.attachMedia(video);
                        hls.on(Hls.Events.ERROR, function (event, errorData) {
                            if (errorData.fatal) {
                                setStatus(player, 'حدث خطأ أثناء تشغيل الفيديو المحمي.', 'error');
                            }
                        });
                    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                        video.src = data.src;
                    } else {
                        throw new Error('المتصفح لا يدعم تشغيل الفيديو المحمي');
                    }
                } else {
                    video.src = data.src;
                }
            })
            .catch(function (error) {
                setStatus(player, error.message || 'تعذر تحميل الفيديو', 'error');
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.protected-video-player[data-playback-url]').forEach(function (player) {
            initProtectedPlayer(player);
        });
    });

    window.addEventListener('beforeunload', function () {
        document.querySelectorAll('.protected-video-player').forEach(function (player) {
            destroyHls(player._hlsInstance);
        });
    });
})();
