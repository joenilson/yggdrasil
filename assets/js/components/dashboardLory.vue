<template>

      <div class="tile is-parent">
        <article class="tile is-child box notification">
          <div class="lory-container">
          <lory class="columns is-mobile js_rewind" :options="{ enableMouseEvents: true, infinite: 3, slidesToScroll: 1, slideSpeed: 1000, ease: 'cubic-bezier(0.455, 0.03, 0.515, 0.955)', rewind: true }">
            <item class="column is-one-quarter-mobile is-3">1</item>
            <item class="column is-one-quarter-mobile is-3">2</item>
            <item class="column is-one-quarter-mobile is-3">3</item>
            <item class="column is-one-quarter-mobile is-3">4</item>
            <item class="column is-one-quarter-mobile is-3">5</item>
            <item class="column is-one-quarter-mobile is-3">6</item>
            <item class="column is-one-quarter-mobile is-3">7</item>
            <item class="column is-one-quarter-mobile is-3">8</item>
            <prev slot="actions" color="#dbdbdb"></prev>
            <next slot="actions" color="#dbdbdb"></next>
          </lory>
          </div>
        </article>

    </div>
</template>

<script>
import { Lory, Item, Prev, Next } from 'vue-lory'
export default {
  name: 'dashboard-lory',
  components: {
    Lory,
    Item,
    Prev,
    Next
  }
}
</script>

<style lang="scss" scoped>
/*.slider {
  .frame li {
    height: 130px;
  }
  &.js_rewind {
    .frame li {
      color: #000;
      background: whitesmoke;
    }
  }

}*/
</style>
