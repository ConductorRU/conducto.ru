/*Vue.component('chat', {
  props: ["messages"],
  template:
  `<li v-for="mes in messages">
    <div>Name: {{mes.username}}</div>
    <div>Age: {{mes.text}}</div>
  </li>`
});*/
Vue.component('chat', {
  data: function(){
      return {
          header: 'Counter Program'
      }
  },
  props: ["messages"],
  template:`<div>
    <div class="post" v-for="mes in messages">
      <div class="name">{{mes.username}}</div>
      <div class="text">{{mes.text}}</div>
    </div>
    </div>`
});
var chat = new Vue({
  el: "#chat",
  data: {
    messages: [
    {
      username: 'Аноним 1',
      text: 'Текст'
    },
    {
      username: 'Аноним 2',
      text: 'Текст'
    },
    {
      username: 'Аноним 1',
      text: 'Текст'
    }]
  },
  methods:
  {
    onSend: function()
    {
      this.$emit('send', this.userName);
    }
  }
});
