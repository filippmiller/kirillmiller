(function($, window, document, undefined) {
    "use strict";
    // Create the defaults once
    var pluginName = "gmWaveSurfer";

    // The actual plugin constructor
    function Plugin(element, options, content) {
        this.el = element;
        this.$el = $(element);
        this.id = this.$el.attr('id');
        this.$list = $('.ws-soundList', this.$el);
        this.content = content;
        this.opts = options;
        this.storage = {likes: []};
        this.timeInterval = 0;
        this.currentTrack;
        this.trackRepeat = false;
        this.globalVolume = 1;
        this.pixelRatio = window.devicePixelRatio || screen.deviceXDPI / screen.logicalXDPI;

        this.init();
    }

    // Avoid Plugin.prototype conflicts
    $.extend(Plugin.prototype, {

        _defaults: {
            link_button_text: 'More',
            color1: 'ff8800',
            color2: 'a1a1a1',
            color3: '000000',
            color4: 'ffffff',
            nonce: '',
            ajaxurl: ((GmediaGallery && GmediaGallery.ajaxurl)? GmediaGallery.ajaxurl : ''),
            key: ''
        },
        _defaults_int: {},
        _defaults_bool: {
            compact_list: false,
            play_next_in_list: true,
            show_tags: true,
            show_categories: true,
            show_albums: true,
            show_cover: true,
            show_big_cover: false,
            show_like_button: true,
            show_share_button: true,
            show_download_button: false,
            show_link_button: true,
            show_views: true,
            show_comments: true
        },

        init: function() {
            this.opts = this.sanitizeOptions(this.opts);
            this.opts = $.extend(true, {}, this._defaults, this._defaults_int, this._defaults_bool, this.opts);
            this.prepareDom();

            var self = this,
                gid = this.id;

            if(typeof window.GmediaGallery.wavesurfer !== 'object') {
                window.GmediaGallery.wavesurfer = {};
            }

            var soundList__item = $('.ws-soundList__item', self.$list);
            soundList__item.eq(0).addClass('ws-active-item');
            soundList__item.each(function() {
                var id = parseInt($(this).attr('data-id'));
                if(self.arrVal(self.storage.likes, id)) {
                    $(this).addClass('ws-liked');
                }
            });

            if(self.opts.compact_list) {
                if(soundList__item.length > 1) {
                    var soundListCopy = soundList__item.clone().append('<div class="ws-item-progress"></div>');
                    $('.ws-sound__author, .ws-visualSound__background, .ws-soundTitle__additionalContainer, .ws-sound__waveform, .ws-sound__soundActions', soundListCopy).remove();
                    $('.ws-have-background', soundListCopy).removeClass('ws-have-background');
                    $('.ws-soundCompactList', self.$el).html(soundListCopy);

                    $('.ws-soundCompactList .ws-soundList__item', self.$el).on('click', function(e) {
                        var target = $(e.target);
                        if(!target.is('a') && !target.is('.ws-button-play')) {
                            $('.ws-button-play', this).trigger('click');
                        }
                    });
                }
            }

            soundList__item.each(function() {
                var el = $('.ws-waveform__layer', this),
                    data = el.data();
                if(data.peaks) {
                    self.waveplayer(el);
                    el.parent().addClass('ws-waveform__peaks');
                }
            });

            $('.ws-button-play', self.$el).on('click', function() {
                var id = $(this).closest('.ws-soundList__item').attr('data-id'),
                    el = $('.ws-soundList__item[data-id="'+id+'"]', self.$list).find('.ws-waveform__layer'),
                    data = el.data();

                if(typeof window.GmediaGallery.wavesurfer == 'undefined' || typeof window.GmediaGallery.wavesurfer[gid + '_' + data.key] == 'undefined') {
                    self.waveplayer(el);
                }

                if($(this).hasClass('ws-button-pause') || $(this).hasClass('ws-button-buffering')) {
                    window.GmediaGallery.wavesurfer[gid + '_' + data.key].pause();
                    return false;
                }

                window.GmediaGallery.wavesurfer[gid + '_' + data.key].play();
            });
            $('.ws-waveform__layer', self.$list).on('click', function(e) {
                var el = $(this).closest('.ws-sound__content').find('.ws-waveform__layer'),
                    data = el.data();

                if(typeof window.GmediaGallery.wavesurfer == 'undefined' || typeof window.GmediaGallery.wavesurfer[gid + '_' + data.key] == 'undefined') {
                    self.waveplayer(el);
                }

                if(!window.GmediaGallery.wavesurfer[gid + '_' + data.key].isPlaying()) {
                    window.GmediaGallery.wavesurfer[gid + '_' + data.key].play();
                    $(this).trigger('clickToPlay');
                }
            });

            var resize;
            $(window).on('resize.ws', function() {
                clearTimeout(resize);
                resize = setTimeout(function() {
                    $('.ws-waveform__layer', self.$list).each(function() {
                        var data = $(this).data();
                        data.peaks = $.parseJSON($(this).attr('data-peaks'));
                        if(data.peaks && window.GmediaGallery.wavesurfer[gid + '_' + data.key]) {
                            window.GmediaGallery.wavesurfer[gid + '_' + data.key].backend.setPeaks(data.peaks);
                            window.GmediaGallery.wavesurfer[gid + '_' + data.key].drawBuffer();

                        }
                    });
                }, 200);
                if(self.opts.show_cover) {
                    var el_w = self.$list.width();
                    if(el_w <= 480){
                        $('.ws-soundList, .ws-soundCompactList', self.$el).addClass('ws-hide-cover');
                    } else {
                        $('.ws-soundList, .ws-soundCompactList', self.$el).removeClass('ws-hide-cover');
                    }
                }
            });
            $(window).trigger('resize.ws');

            $('.ws-button-like', self.$el).on('click', function() {
                var item = $(this).closest('.ws-soundList__item');
                if(!item.hasClass('ws-liked')) {
                    var id = item.attr('data-id');
                    item.addClass('ws-liked');
                    self.trackLike(id);
                }
            });
            $('.ws-button-share', self.$list).on('click', function() {
                var t = $(this);
                if(!t.hasClass('ws-button-active')) {
                    var item = t.closest('.ws-soundList__item');
                    var sharers = self.share(item);
                    t.after(sharers);
                }
                t.siblings().stop().animate(
                    {
                        width: ["toggle", "swing"],
                        padding: ["toggle", "swing"],
                        margin: ["toggle", "swing"],
                        opacity: "toggle"
                    }, 200).promise().done(function() {
                    if(t.hasClass('ws-button-active')) {
                        t.removeClass('ws-button-active');
                        t.parent().find('.ws-sharelizers').remove();
                    } else {
                        t.addClass('ws-button-active');
                    }
                });
            });

        },
        sanitizeOptions: function(options) {
            var self = this;
            return $.each(options, function(key, val) {
                if(key in self._defaults_bool) {
                    options[key] = (!(!val || val == '0' || val == 'false'));
                } else if(key in self._defaults_int) {
                    options[key] = parseInt(val);
                }
            });

        },
        prepareDom: function() {
            if(window.sessionStorage) {
                var sesion_storage = sessionStorage.getItem('GmediaGallery');
                if(sesion_storage) {
                    $.extend(true, this.storage, JSON.parse(sesion_storage));
                }
                var globalVolume = sessionStorage.getItem('GmediaMusic_volume');
                if(globalVolume) {
                    this.globalVolume = globalVolume;
                }
            }
        },
        waveplayer: function(el) {
            var self = this,
                gid = this.id,
                data = $(el).data(),
                id = data.key.replace('ws', ''),
                item = $('[data-id="' + id + '"]', self.$el),
                timer_el = $(el).closest('.ws-waveform').find('.ws-wave_time'),
                time_ = 0,
                ch = 0;

            window.GmediaGallery.wavesurfer[gid + '_' + data.key] = Object.create(WaveSurfer);
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].init({
                container: '#' + gid + ' .ws-waveform__layer[data-key="' + data.key + '"]',
                waveColor: '#' + self.opts.color2,
                progressColor: '#' + self.opts.color1,
                height: 78,
                barWidth: 2,
                backend: 'MediaElement',
                cursorWidth: 0,
                normalize: true,
                interact: false,
                gmProgressWave: true
            });

            window.GmediaGallery.wavesurfer[gid + '_' + data.key].backend.setPeaks(data.peaks);
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].drawBuffer();

            var hoverX;
            $(window.GmediaGallery.wavesurfer[gid + '_' + data.key].container).on('mousemove clickToPlay', function(e) {
                if(e.type === 'mousemove') {
                    hoverX = e.offsetX * self.pixelRatio;
                }
                if(window.GmediaGallery.wavesurfer[gid + '_' + data.key].isPlaying() || e.type === 'clickToPlay') {
                    var drawer = window.GmediaGallery.wavesurfer[gid + '_' + data.key].drawer;
                    if(hoverX) {
                        var progress = hoverX / drawer.gmWidth;
                        drawer.iMaxHover = Math.ceil(drawer.gmPeaksLength * progress);
                    }
                    window.GmediaGallery.wavesurfer[gid + '_' + data.key].drawer.updateProgress(drawer.gmProgress);
                }
            }).on('mouseleave', function() {
                window.GmediaGallery.wavesurfer[gid + '_' + data.key].drawer.iMaxHover = false;
            }).on('click', function(){
                if(window.GmediaGallery.wavesurfer[gid + '_' + data.key].isPlaying()) {
                    window.GmediaGallery.wavesurfer[gid + '_' + data.key].backend.media.currentTime = 0;
                }
            });
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].on('ready', function() {
                //console.log('ready');
                window.GmediaGallery.wavesurfer[gid + '_' + data.key].setVolume(self.globalVolume);
                $(el).parent().removeClass('ws-loading').addClass('ws-loaded');
                var post_data = {action: 'gmedia_module_interaction', hit: id};
                $.post(ajaxurl, post_data, function(data, textStatus, jqXHR) {
                    if(data.views) {
                        $('.ws-ministats-plays span', item).text(data.views);
                    }
                });
                if(!data.peaks) {
                    var savePeaks = setInterval(function(){
                        var peaks = window.GmediaGallery.wavesurfer[gid + '_' + data.key].exportPCM(1800, 10000, true);
                        if(peaks && peaks !== '[]'){
                            var post_data = {
                                action: 'gmedia_save_waveform',
                                id: id,
                                peaks: peaks,
                                _wpnonce: self.opts.nonce
                            };
                            $.post(ajaxurl, post_data, function(data, textStatus, jqXHR) {
                                el.attr('data-peaks', peaks);
                            });

                            clearInterval(savePeaks);
                        }
                    }, 1000);
                }
            });
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].on('play', function() {

                $.each(window.GmediaGallery.wavesurfer, function(key) {
                    if(key !== (gid + '_' + data.key) && (window.GmediaGallery.wavesurfer[key].isPlaying() || $(window.GmediaGallery.wavesurfer[key].container).closest('.ws-sound__content').find('.ws-button-play').hasClass('ws-button-buffering'))) {
                        window.GmediaGallery.wavesurfer[key].pause();
                    }
                });
                item.addClass('ws-active-item').siblings().removeClass('ws-active-item');

                window.GmediaGallery.wavesurfer[gid + '_' + data.key].fireEvent('audioprocess', time_);

                if(!$(el).parent().hasClass('ws-loaded') && !$(el).parent().hasClass('ws-loading')) {
                    $(el).parent().addClass('ws-loading');

                    window.GmediaGallery.wavesurfer[gid + '_' + data.key].load(data.file, data.peaks);
                    window.GmediaGallery.wavesurfer[gid + '_' + data.key].play();

                    return;
                }

                $('.ws-button-play', item).addClass('ws-button-pause');

                if(window.GmediaGallery_wavesurfer_currentTrack != (gid + '_' + data.key)) {
                    window.GmediaGallery_wavesurfer_currentTrack = gid + '_' + data.key;
                    self.globalPlayer();
                }
                if(self.playControls && self.playControls.length) {
                    $('.ws-playControl', self.playControls).addClass('ws-playing');
                }

                window.GmediaGallery.wavesurfer[gid + '_' + data.key].params.interact = true;

            })
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].on('pause', function() {
                //console.log('pause');
                $(el).parent().removeClass('ws-loading');
                $('.ws-button-play', item).removeClass('ws-button-pause ws-button-buffering');
                clearInterval(self.timeInterval);
                ch = 0;

                if(self.playControls && self.playControls.length) {
                    $('.ws-playControl', self.playControls).removeClass('ws-playing');
                }
                window.GmediaGallery.wavesurfer[gid + '_' + data.key].params.interact = false;
            });
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].on('loading', function(p) {
                //console.log('loading', p);
                if(p == 100) {
                    $(el).closest('.ws-sound__content').find('.ws-button-play').removeClass('ws-button-buffering');
                } else {
                    $(el).closest('.ws-sound__content').find('.ws-button-play').addClass('ws-button-buffering');
                }
                ch = 2;
            });
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].on('finish', function() {
                //console.log('finish');
                window.GmediaGallery.wavesurfer[gid + '_' + data.key].pause();
                clearInterval(self.timeInterval);

                var playtime = self.timeFormat();
                timer_el.text(playtime);
                if(self.playControls && self.playControls.length) {
                    $('.ws-playControl', self.playControls).removeClass('ws-playing');
                    $('.ws-playbackTimeline__timePassed', self.playControls).text(playtime);
                }
                if(self.trackRepeat) {
                    setTimeout(function() { window.GmediaGallery.wavesurfer[gid + '_' + data.key].play(); }, 100);
                } else {
                    if(self.opts.play_next_in_list){
                        $(el).closest('.ws-soundList__item').next().find('.ws-button-play').click();
                    }
                }
            });

            var processstack = 0, progressItem = $('.ws-soundCompactList .ws-soundList__item[data-id="' + id + '"]', self.$el).find('.ws-item-progress'), progress;
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].on('audioprocess', function(time) {

                if(time_ == time) {
                    processstack++;
                } else{
                    processstack = 0;
                }
                if(ch && processstack < 5) {
                    if(ch === 1) {
                        $(el).closest('.ws-sound__content').find('.ws-button-play').removeClass('ws-button-buffering');
                        ch = 2;
                        var playtime,
                            is_playControls = self.playControls && self.playControls.length;
                        if(is_playControls) {
                            $('.ws-playControl', self.playControls).addClass('ws-playing');
                        }
                        clearInterval(self.timeInterval);
                        self.timeInterval = setInterval(function() {
                            playtime = self.timeFormat(time_);
                            timer_el.text(playtime);
                            if(is_playControls) {
                                $('.ws-playbackTimeline__timePassed', self.playControls).text(playtime);
                            }
                            progress = window.GmediaGallery.wavesurfer[gid + '_' + data.key].backend.getPlayedPercents() * 100;
                            progressItem.width(progress + '%');
                        }, 200);
                        //console.log('audioprocess play', ch, time, time_);
                    }
                } else {
                    if(ch === 2 || ch === 0) {
                        if(!time_ && ch === 0) {
                            var playtime = self.timeFormat(time_);
                            timer_el.text(playtime);
                            progress = window.GmediaGallery.wavesurfer[gid + '_' + data.key].backend.getPlayedPercents() * 100;
                            progressItem.width(progress + '%');
                        }
                        $(el).closest('.ws-sound__content').find('.ws-button-play').addClass('ws-button-buffering');
                        //console.log('audioprocess buffer', ch, time, time_);
                        ch = 1;
                    }
                }
                //console.log('audioprocess', ch, time, time_);
                if(time) {
                    time_ = time;
                }
            });
            window.GmediaGallery.wavesurfer[gid + '_' + data.key].on('seek', function(time) {
                time_ = window.GmediaGallery.wavesurfer[gid + '_' + data.key].getCurrentTime();
                var playtime = self.timeFormat(time_);
                //console.log('seek', time, time_, playtime);
                timer_el.text(playtime);
                if(self.playControls && self.playControls.length) {
                    $('.ws-playbackTimeline__timePassed', self.playControls).text(playtime);
                }
            });
        },
        globalPlayer: function() {
            var self = this,
                gid = this.id,
                playControls = $('body').find('.ws-playControls'),
                is_playControls = playControls.length;
            if(!is_playControls) {
                var html = '\
<div class="wavesurfer_module ws-playControls">\
    <div class="ws-playControls__inner">\
        <div class="ws-playControls__wrapper">\
            <ul class="ws-playControls__controls ws-list-nostyle ws-g-dark ws-clearfix">\
                <li class="ws-playControls__playPauseSkip">\
                    <button class="ws-skipControl ws-playControls__icon ws-ir ws-skipControl__previous">«</button>\
                    <button class="ws-playControl ws-playControls__icon ws-ir">►</button>\
                    <button class="ws-skipControl ws-playControls__icon ws-ir ws-skipControl__next">»</button>\
                </li>\
                <li class="ws-playControls__repeat"><button class="ws-repeatControl ws-ir">➀</button></li>\
                <li class="ws-playControls__volume">\
                    <div class="ws-volume" data-level="10">\
                        <div class="ws-volume__iconWrapper"><button class="ws-volume__button ws-volume__speakerIcon ws-ir">☊</button></div>\
                        <div class="ws-volume__sliderWrapper" role="slider"><div class="ws-volume__sliderBackground"><div class="ws-volume__sliderProgress" style="height: 100%;"></div></div></div>\
                    </div>\
                </li>\
            </ul>\
            <div class="ws-playControls__soundBadge">\
                <div class="ws-playbackSoundBadge">\
                    <div class="ws-playbackSoundBadge__avatar ws-media-image"></div>\
                    <div class="ws-playbackSoundBadge__titleContextContainer">\
                        <a href="#" target="_blank" class="ws-playbackSoundBadge__title ws-truncate"><span>&nbsp;</span></a>\
                        <div class="ws-playbackTimeline"><span class="ws-playbackTimeline__timePassed">-:--</span> / <span class="ws-playbackTimeline__duration">-:--</span></div>\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>\
</div>\
                ';
                $('body').append(html);

                playControls = $('body').find('.ws-playControls');
                is_playControls = playControls.length;
                setTimeout(function() {
                    playControls.addClass('ws-m-visible');
                    self.updateVolume(false, self.globalVolume, true);
                }, 0);

                $('.ws-playControl', playControls).on('click', function() {
                    var key = window.GmediaGallery_wavesurfer_currentTrack;
                    window.GmediaGallery.wavesurfer[key].playPause();
                });
                $('.ws-skipControl__previous', playControls).on('click', function() {
                    var key = window.GmediaGallery_wavesurfer_currentTrack,
                        items = $('.ws-soundList .ws-soundList__item'),
                        i = $(window.GmediaGallery.wavesurfer[key].container).closest('.ws-soundList__item').index('.ws-soundList__item');
                    if(i - 1 >= 0) {
                        var el = items.eq(i - 1).find('.ws-waveform__layer'),
                            data = el.data();
                        window.GmediaGallery.wavesurfer[gid + '_' + data.key].backend.media.currentTime = 0;
                        items.eq(i - 1).find('.ws-button-play').click();
                    }
                });
                $('.ws-skipControl__next', playControls).on('click', function() {
                    var key = window.GmediaGallery_wavesurfer_currentTrack,
                        items = $('.ws-soundList .ws-soundList__item'),
                        i = $(window.GmediaGallery.wavesurfer[key].container).closest('.ws-soundList__item').index('.ws-soundList__item');

                    if(items.eq(i + 1).length) {
                        var el = items.eq(i + 1).find('.ws-waveform__layer'),
                            data = el.data();
                        window.GmediaGallery.wavesurfer[gid + '_' + data.key].backend.media.currentTime = 0;
                        items.eq(i + 1).find('.ws-button-play').click();
                    }
                });
                $('.ws-repeatControl', playControls).on('click', function() {
                    $(this).toggleClass('ws-m-active');
                    self.trackRepeat = self.trackRepeat? false : true;
                });
                $('.ws-volume', playControls).hover(function() {
                    $(this).addClass('ws-expanded');
                }, function() {
                    $(this).removeClass('ws-expanded');
                });
                $('.ws-playbackSoundBadge__avatar', playControls).on('click', function() {
                    var key = window.GmediaGallery_wavesurfer_currentTrack;
                    var trackContainer = $(window.GmediaGallery.wavesurfer[key].container).closest('.ws-soundList__item');
                    //var scrolled = trackContainer.parents().filter(function() {
                    //    return this.scrollHeight > $(this).outerHeight();
                    //});
                    //if(scrolled.length) {
                    //    var deferScroll = function(i) {
                    //        if(typeof scrolled[i] !== 'undefined') {
                    //            $(scrolled[i]).animate({
                    //                scrollTop: (trackContainer.offset().top - $(scrolled[i]).offset().top + $(scrolled[i]).scrollTop() - 50)
                    //            }, 600, function() {
                    //                deferScroll(i + 1);
                    //            });
                    //        }
                    //    }
                    //    deferScroll(0);
                    //}
                    self.$el.parent().stop().animate({scrollTop: trackContainer.offset().top - 50}, 400);
                    $('html, body').stop().animate({scrollTop: trackContainer.offset().top - 50}, 400);

                });

                var volumeDrag = false;
                $('.ws-volume__button', playControls).on('click', function(e) {
                    var setVolume;
                    if(self.globalVolume) {
                        $(this).data('volume', self.globalVolume);
                        setVolume = 0;
                    } else {
                        setVolume = parseFloat($(this).data('volume'));
                    }
                    self.updateVolume(false, setVolume, true);
                });
                $('.ws-volume__sliderWrapper', playControls).on('mousedown', function(e) {
                    if($(this).parent().hasClass('ws-expanded')) {
                        volumeDrag = true;
                        self.updateVolume(e.pageY);
                    }
                });
                $(document).on('mouseup', function(e) {
                    if(volumeDrag) {
                        volumeDrag = false;
                        self.updateVolume(e.pageY, false, true);
                    }
                });
                $(document).on('mousemove', function(e) {
                    if(volumeDrag) {
                        self.updateVolume(e.pageY);
                    }
                });

            }

            if(is_playControls) {
                playControls.attr('data-id', self.id);
                var key = window.GmediaGallery_wavesurfer_currentTrack;
                var trackContainer = $(window.GmediaGallery.wavesurfer[key].container).closest('.ws-soundList__item');
                $('.ws-playbackSoundBadge__avatar', playControls).html($('.ws-sound__coverArt', trackContainer).html());
                var title = $('.ws-soundTitle__title', trackContainer);
                $('.ws-playbackSoundBadge__title', playControls).html(title.html()).attr('href', title.attr('href')).attr('title', $.trim(title.text()));
                $('.ws-playbackTimeline__timePassed', playControls).text($('.ws-wave_time', trackContainer).text());
                $('.ws-playbackTimeline__duration', playControls).text($('.ws-track_time', trackContainer).text());

                this.playControls = playControls;
            }

            return is_playControls;
        },
        updateVolume: function(y, vol, all) {
            var volume = $('.ws-volume__sliderBackground', this.playControls);
            var percentage;

            if(vol || vol === 0) {
                percentage = vol * 100;
            } else {
                var position = volume.height() - (y - volume.offset().top);
                percentage = 100 * position / volume.height();
            }

            if(percentage > 100) {
                percentage = 100;
            }
            if(percentage < 0) {
                percentage = 0;
            }

            //update volume bar and video volume
            $('.ws-volume__sliderProgress', this.playControls).css('height', percentage + '%');
            var volume = percentage / 100;

            //change sound icon based on volume
            if(volume > 0.8) {
                $('.ws-volume', this.playControls).attr('data-level', '10');
            } else if(volume) {
                $('.ws-volume', this.playControls).attr('data-level', '4');
            } else {
                $('.ws-volume', this.playControls).attr('data-level', '0');
            }

            if(all) {
                var gid = this.id;
                this.globalVolume = volume;
                $.each(window.GmediaGallery.wavesurfer, function(key) {
                    window.GmediaGallery.wavesurfer[key].setVolume(volume);
                });
                sessionStorage.setItem('GmediaMusic_volume', volume);
            } else {
                var key = window.GmediaGallery_wavesurfer_currentTrack;
                window.GmediaGallery.wavesurfer[key].setVolume(volume);
            }
        },
        timeFormat: function(input) {
            if(!input) {
                return "0:00";
            }

            var minutes = Math.floor(input / 60);
            var seconds = Math.round(input) % 60;

            //return (minutes < 10? '0' : '') +
            return minutes + ":" + (seconds < 10? '0' : '') + seconds;
        },
        trackLike: function(id) {
            var like = 0,
                id = parseInt(id),
                index = $.inArray(id, this.storage.likes);
            if(index === -1) {
                this.storage.likes.push(id);
                like = 1;

                //} else {
                //    this.storage.likes.splice(index, 1);
                //    like = -1;
                //}

                sessionStorage.setItem('GmediaGallery', JSON.stringify(this.storage));
                if(like && this.opts.ajaxurl) {
                    var self = this;
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: this.opts.ajaxurl,
                        data: {action: 'gmedia_module_interaction', hit: id, like: like}
                    }).done(function(r) {
                        if(typeof r.likes !== 'undefined') {
                            $('[data-id="' + id + '"] .ws-button-like', self.$el).text(r.likes);
                        }
                    });
                }
            }
        },
        share: function(item) {
            var title = $.trim($('.ws-soundTitle__title', item).text()),
                url = $('.ws-soundTitle__title', item).attr('href'),
                imgsrc = $('.ws-sound__coverArt', item).attr('data-cover'),
                html;

            html = '' +
                '<div class="ws-sharelizers">' +
                '<a href="https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url) + '" target="_blank" class="ws-share-facebook ws-sharelizer">Facebook</a>' +
                '<a href="https://twitter.com/share?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(title) + '" target="_blank" class="ws-share-twitter ws-sharelizer">Twitter</a>' +
                    //'<a href="https://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=' + encodeURIComponent(imgsrc) + '&description=' + encodeURIComponent(title) + '" target="_blank" class="ws-share-pinterest ws-sharelizer">Pinterest</a>' +
                '<a href="https://plus.google.com/share?url=' + encodeURIComponent(url) + '" target="_blank" class="ws-share-googleplus ws-sharelizer">Google+</a>' +
                    //'<a href="http://www.stumbleupon.com/submit?url=' + encodeURIComponent(url) + '&title=' + encodeURIComponent(title) + '" target="_blank" class="ws-share-stumbleupon ws-sharelizer">StumbleUpon</a>' +
                '<a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=' + encodeURIComponent(url) + '&posttype=audio&tags=&caption=' + encodeURIComponent(title) + '" target="_blank" class="ws-share-tumblr ws-sharelizer">Tumblr</a>' +
                '<a href="http://vkontakte.ru/share.php?url=' + encodeURIComponent(url) + '" target="_blank" class="ws-share-vkontakte ws-sharelizer">VK</a>' +
                '</div>';

            return html;
        },
        arrVal: function(arr, val) {
            return $.inArray(val, arr) !== -1? val : false;
        },
        $_GET: function(variable) {
            var url = window.location.href.split('?')[1];
            if(url) {
                url = url.split('#')[0];
                var variables = (typeof(url) === 'undefined')? [] : url.split('&'),
                    i;

                for(i = 0; i < variables.length; i++) {
                    if(variables[i].indexOf(variable) != -1) {
                        return variables[i].split('=')[1];
                    }
                }
            }

            return false;
        }
    });

    $.fn[pluginName] = function(options, content) {
        options = options || {};
        content = content || {};
        return this.each(function() {
            if(!$.data(this, pluginName)) {
                var pluginInstance = new Plugin(this, options, content);
                $.data(this, pluginName, pluginInstance);
            }
        });
    };

})(jQuery, window, document);

WaveSurfer.util.extend(WaveSurfer.Drawer.Canvas, {
    iMaxProgress: 0,
    iMaxHover: false,
    createElements: function() {
        var waveCanvas = this.wrapper.appendChild(
            this.style(document.createElement('canvas'), {
                position: 'absolute',
                zIndex: 1,
                left: 0,
                top: 0,
                bottom: 0
            })
        );
        this.waveCc = waveCanvas.getContext('2d');

//        if(this.params.cursorWidth || this.params.progressWave) {
        this.progressWave = this.wrapper.appendChild(
            this.style(document.createElement('wave'), {
                position: 'absolute',
                zIndex: 2,
                left: 0,
                top: 0,
                bottom: 0,
                overflow: 'hidden',
                width: '0',
                display: 'none',
                boxSizing: 'border-box',
                borderRightStyle: 'solid',
                borderRightWidth: this.params.cursorWidth + 'px',
                borderRightColor: this.params.cursorColor
            })
        );

        if(!this.params.gmProgressWave && (this.params.waveColor != this.params.progressColor)) {
            var progressCanvas = this.progressWave.appendChild(
                document.createElement('canvas')
            );
            this.progressCc = progressCanvas.getContext('2d');
        }
//        }

    },
    drawBars: function(peaks, channelIndex) {
        // Split channels
        if(peaks[0] instanceof Array) {
            var channels = peaks;
            if(this.params.splitChannels) {
                this.setHeight(channels.length * this.params.height * this.params.pixelRatio);
                channels.forEach(this.drawBars, this);
                return;
            } else {
                peaks = channels[0];
            }
        }

        // Bar wave draws the bottom only as a reflection of the top,
        // so we don't need negative values
        var hasMinVals = [].some.call(peaks, function(val) { return val < 0; });
        if(hasMinVals) {
            peaks = [].filter.call(peaks, function(_, index) { return index % 2 == 0; });
        }

        // A half-pixel offset makes lines crisp
        //var $ = 0.5 / this.params.pixelRatio;
        var width = this.gmWidth = this.width;
        var height = this.gmHeight = this.params.height * this.params.pixelRatio;
        var offsetY = this.gmOffsetY = height * channelIndex || 0;
        var halfH = this.gmHalfH = (height + height / 4) / 2;
        var bar = this.gmBar = this.params.barWidth * this.params.pixelRatio;
        var gap = this.gmGap = Math.max(this.params.pixelRatio, ~~(bar / 2));
        var step = this.gmStep = bar + gap;

        peaks = this.gmPeaks = this.gmGetPeaks(Math.ceil(width / step), peaks);
        var peaksLength = this.gmPeaksLength = peaks.length;

        var absmax = this.gmAbsmax = 1;
        if(this.params.normalize) {
            absmax = this.gmAbsmax = Math.max.apply(Math, peaks);
        }

        this.waveCc.fillStyle = this.params.waveColor;
        if(this.progressCc) {
            this.progressCc.fillStyle = this.params.progressColor;
        }

        this.gmTopColor = this.params.waveColor;
        this.gmBottomColor = this.hex2rgba(this.gmTopColor, 0.5);
        this.gmTopColorProgress = this.params.progressColor;
        this.gmBottomColorProgress = this.hex2rgba(this.gmTopColorProgress, 0.5);
        this.gmTopColorHover = this.colorLuminance(this.params.progressColor, -0.2);
        var self = this;
        var topColor, bottomColor;
        [this.waveCc, this.progressCc].forEach(function(cc) {
            if(!cc) { return; }

            for(var i = 0, j = 0, iMax = peaksLength; i < iMax; i++, j += step) {
                if(i < self.iMaxProgress) {
                    topColor = self.gmTopColorProgress;
                    bottomColor = self.gmBottomColorProgress;
                } else {
                    topColor = self.gmTopColor;
                    bottomColor = self.gmBottomColor;
                }

                var h = Math.round(peaks[i] / absmax * halfH);
                cc.clearRect(j, 0, bar, height);
                cc.fillStyle = topColor;
                cc.fillRect(j, halfH - h + offsetY, bar, h);
                cc.fillStyle = bottomColor;
                cc.fillRect(j, halfH + gap, bar, Math.round(h / 2));
            }
        }, this);
    },
    updateProgress: function(progress) {
        var pos = Math.round(
                this.width * progress
            ) / this.params.pixelRatio;
        this.style(this.progressWave, {width: pos + 'px'});

        if(this.params.gmProgressWave) {
            var width = this.gmWidth;
            var height = this.gmHeight;
            var offsetY = this.gmOffsetY;
            var halfH = this.gmHalfH;
            var bar = this.gmBar;
            var gap = this.gmGap;
            var step = this.gmStep;
            var peaks = this.gmPeaks;
            var absmax = this.gmAbsmax;
            var peaksLength = this.gmPeaksLength;
            var iMaxProgress = this.iMaxProgress = Math.ceil(peaksLength * progress);
            var iMaxHover = this.iMaxHover;

            this.gmProgress = progress;

            var cc = this.waveCc
            var topColor, bottomColor;
            for(var i = 0, j = 0, iMax = peaks.length; i < iMax; i++, j += step) {
                if(i < iMaxProgress) {
                    topColor = this.gmTopColorProgress;
                    bottomColor = this.gmBottomColorProgress;
                } else {
                    topColor = this.gmTopColor;
                    bottomColor = this.gmBottomColor;
                }
                if(iMaxHover !== false) {
                    if(iMaxHover < iMaxProgress) {
                        if(i >= iMaxHover && i < iMaxProgress) {
                            topColor = this.gmTopColorHover;
                        }
                    } else if(iMaxHover >= iMaxProgress) {
                        if(i < iMaxHover && i >= iMaxProgress) {
                            topColor = this.gmTopColorHover;
                        }
                    }
                }
                var h = Math.round(peaks[i] / absmax * halfH);
                cc.clearRect(j, 0, bar, height);
                cc.fillStyle = topColor;
                cc.fillRect(j, halfH - h + offsetY, bar, h);
                cc.fillStyle = bottomColor;
                cc.fillRect(j, halfH + gap, bar, Math.round(h / 2));
            }
        }
    },
    gmGetPeaks: function(length, allpeaks) {
        var sampleSize = allpeaks.length / length;
        var sampleStep = ~~(sampleSize / 10) || 1;

        var peaks = [];

        for(var i = 0; i < length; i++) {
            var start = ~~(i * sampleSize);
            var end = ~~(start + sampleSize);
            var max = 0;

            for(var j = start; j < end; j += sampleStep) {
                var value = allpeaks[j];

                if(value > max) {
                    max = value;
                }
            }

            peaks[i] = max;
        }

        return peaks;
    },
    colorLuminance: function(hex, lum) {
        // validate hex string
        hex = String(hex).replace(/[^0-9a-f]/gi, '');
        if(hex.length < 6) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        lum = lum || 0;

        // convert to decimal and change luminosity
        var rgb = "#", c, i;
        for(i = 0; i < 3; i++) {
            c = parseInt(hex.substr(i * 2, 2), 16);
            c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
            rgb += ("00" + c).substr(c.length);
        }

        return rgb;
    },
    hex2rgba: function(hex, opacity) {
        // validate hex string
        hex = String(hex).replace(/[^0-9a-f]/gi, '');
        if(hex.length < 6) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        var result = 'rgba(' + parseInt(hex.substring(0, 2), 16) + ',' + parseInt(hex.substring(2, 4), 16) + ',' + parseInt(hex.substring(4, 6), 16) + ',' + opacity + ')';
        return result;
    }
});