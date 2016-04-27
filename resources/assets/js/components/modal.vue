<template>
    <div class="Modal" v-show="show" transition="Modal" @click="clickOnMask" :class="[class, fullScreen ? 'Modal--Fullscreen' : '']">
        <div class="Modal__Wrapper" @click="clickOnMask">
            <div class="Modal__Wrapper__Container">
                <div class="Modal__Wrapper__Container__Header">
                    <div class="Modal__Wrapper__Container__Header__Buttons" v-if="withFullscreen != false">
                        <button class="Button Button--Small Button--Cancel" @click="this.fullScreen = !this.fullScreen">Plein écran</button>
                    </div>
                    <slot name="header">
                        Laravel France
                    </slot>
                </div>

                <div class="Modal__Wrapper__Container__Body">
                    <slot name="body"></slot>
                </div>

                <div class="Modal__Wrapper__Container__Footer">
                    <slot name="footer">
                        <button @click="show = false">
                            OK
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script  type="text/ecmascript-6">
    export default {
        ready() {

            var w = window,
                    d = document,
                    e = d.documentElement,
                    g = d.getElementsByTagName('body')[0],
                    y = w.innerHeight|| e.clientHeight|| g.clientHeight;

            var wrappercontainer = this.$el.querySelector('.Modal__Wrapper__Container');
            wrappercontainer.style.maxHeight = y-86 + "px";
        },
        methods: {
            clickOnMask(e) {
                e.stopPropagation();
                if (e.target != e.currentTarget) return;

                if (this.fullScreen)  return;

                this.$nextTick(function () {
                    this.show = false;
                })
            },
            toggleFullScreen () {
                this.fullScreen = !this.fullScreen;
            }
        },
        props: {
            fullScreen: {
                type: Boolean,
                default: false,
                twoWay: true
            },
            class: {
                type: String
            },
            withFullscreen: {
                default: false
            },
            show: {
                type: Boolean,
                required: true,
                twoWay: true
            }
        }
    }
</script>
