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
    <div v-for="mes in messages">
      <div>Name: {{mes.username}}</div>
      <div>Age: {{mes.text}}</div>
    </div>
    </div>`
});
var chat = new Vue({
  el: "#chat",
  data: {
    messages: [
    {
      username: 'Tom',
      text: 18
    },
    {
      username: 'Bob',
      text: 23
    },
    {
      username: 'Alice',
      text: 21
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
