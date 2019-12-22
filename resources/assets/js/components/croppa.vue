<template id="">
    <div>
        <croppa v-model="myCroppa" canvas-color="transparent"></croppa>
        <button @click="generateImage">画像作成</button>
        <br>
        <img class="output" :src="imgUrl" >
    </div>
</template>

<script type="text/javascript">
    data: {
        myCroppa: null,
        imgUrl: ''
    },
    methods: {
        generateImage: function() {
            let url = this.myCroppa.generateDataUrl()
            if (!url) {
                alert('no image')
                return
            }
            this.imgUrl = url
        }
    }
</script>