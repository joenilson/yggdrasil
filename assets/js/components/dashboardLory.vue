<template>
  <div class="lory-container">
      <div class="tile is-parent is-vertical">
        <article class="tile is-child box notification">
          <lory :options="{ enableMouseEvents: true, infinite: 1 }">
            <item>1</item>
            <item>2</item>
            <item>3</item>
            <item>4</item>
            <item>5</item>
            <item>6</item>
            <prev slot="actions" color="#dbdbdb"></prev>
            <next slot="actions" color="#dbdbdb"></next>
          </lory>
        </article>
        <article class="tile is-child box notification">
          <lory class="js_rewind" :options="{ enableMouseEvents: true, infinite: 1, rewind: true }">
            <item>1</item>
            <item>2</item>
            <item>3</item>
            <item>4</item>
            <item>5</item>
            <item>6</item>
            <prev slot="actions" color="#dbdbdb"></prev>
            <next slot="actions" color="#dbdbdb"></next>
          </lory>
        </article>
      </div>
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
