<template>
    <div class="tile is-parent">
        <article class="tile is-child box">
            <p class="title has-text-dark">{{parseFloat(title).toLocaleString()}}</p>
            <p class="subtitle has-text-grey-darker">{{subtitle}}</p>
        </article>
    </div>
</template>
<script>
    export default {
        name: 'dashboard-article',
        props: {
            title: Number,
            subtitle: String
        }
    }
</script>