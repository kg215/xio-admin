<template>
    <div class="o-shy-shy">
        <div v-for="item of list" :key="item.uid" :class="['o-shy-box',item.uid===me?'o-shy-me':'o-shy-py']">
            <div class="o-shy-info">
                <img class="o-tx" :src="item.headp">
                <!--<span class="o-shy-name">名字名字名字名字名字名字名字名字名字名字名字名字名字名字</span>-->
                <!--<span class="o-shy-py-date">-->
                <!--{{time}}-->
                <!--</span>-->
            </div>
            <div class="o-shy-msg">
                {{item.msg}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChatBox",
        props: {
            list:Array,
            me:Number
        }
    }
</script>

<style scoped>

</style>
