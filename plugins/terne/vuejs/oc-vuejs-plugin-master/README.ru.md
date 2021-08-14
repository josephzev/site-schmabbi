# Vue.js Plugin
Tools useful for creating websites with Vue.js and OctoberCMS. Inspired by AngularJS Plugin by “Responsiv”.

## High level design consideration
Vue.js is a library for building interactive web interfaces. It provides data-reactive components with a simple and flexible API.

With this plugin you can do the following:
- Create a complete Single Page Application (SPA).
- Create AJAX-enabled sections of the website that behave like SPA (AJAX sections).
- Leverage Vue.js for your front-end templating.

When using this plugin in October, the page layout acts as the entry page. This allows a website to act as multiple SPAs and also as a traditional website. A complete SPA website should use just one layout, whereas a hybrid website could use a layout for each AJAX section along with layouts for the traditional pages. 

## Создание одностраничного приложения.
### Layout Component

Точкой входа в SPA может быть главная страница сайта (тогда весь сайта целиком будет одностраничным приложением) или какая-то из внутренних страниц.
Для точки входа нужно создать Layout и подключить к нему компонент “Layout” из данного плагина. Ниже пример простейшего layout точки входа:
```
  description = "Single Page Application"
  
  [vueLayout]
  root_element_id = "#app"
  enable_routing = 1
  ==
  <!DOCTYPE html>
  <html>
      <head>
          <meta charset="utf-8">
          <title>{{ this.page.title }}</title>
          {% styles %}
      </head>
      <body>
          <div id="app">
              <ul>
                  <li v-link-active><a v-link="{ path: '/', exact: true }">Main page</a></li>
                  <li v-link-active><a v-link="{ path: '/foo' }">Foo page</a></li>
                  <li v-link-active><a v-link="{ path: '/bar' }">Bar page</a></li>
              </ul>
      
              <router-view>{% page %}</router-view>
      
              <script src="{{ [
                  'assets/javascript/jquery.js',
              ]|theme }}">
              </script>
              
              {% scripts %}
              {% framework extras %}
              
              {% component 'vueLayout' %}
          </div>
      </body>
  </html>
```
Компонент включается в layout последним, после `{% scripts %}` и `{% framework extras %}`, также перед компонентом обязательно должен быть подключен jQuery.

В настройках компонента требуется указать корневой элемент DOM, к которому будет подключаться vue-приложение. По умолчанию это элемент с id=’app’. Для указания элемента можно использовать любой CSS-селектор.

Если в SPA требуется использовать routing, то в layout нужно включить тег `<router-view>` в том месте куда должено загружаться содержимое страницы и указать соответствующую настройку в компоненте Layout `enable_routing = 1`. Twig-тэг `{% page %}` внутри тега `<router-view>` обеспечивает загрузку разметки главной страницы.

Ссылки на другие страницы SPA создаются с помощью vue директив `v-link` и `v-link-active`.

В компоненте также есть возможность задавать любые настройки для vue роутера.

### Создание страниц для SPA

После создания SPA Layout нужно указать его для главной страницы нашего SPA-приложения. Для второстепенных страниц, которые будут загружаться в основной SPA Layout можно не задавать собственный layout. 

Url главной страницы SPA приложения будет использоваться как базовый и url всех остальных страниц должен начинаться с него.
Например, если входная страница имеет Url /submit, то остальные страницы должны быть, например, /submit/step1, /submit/step2
```
  layouts/
      submit.htm  <== description: Submission process
  
  pages/
      start.htm    <== url: /submit, layout: submit
      step1.htm     <== url: /submit/step1, layout: -
      step2.htm     <== url: /submit/step2, layout: -
      finish.htm    <== url: /submit/finish, layout: -
```      
Страницы могут использовать компоненты, паршалы, контент-блоки, подключать стили и скрипты.

## Создание компонентов OctoberCMS с использованием компонентов Vue.js

Плагин позволяет использовать Vue.js при создании компонентов OctoberCMS. 

Рассмотрим на примере создания простейшего компонента ToDo - листа. Предположим, что у нас уже создан пустой компонент Todo:
```
  /todo
      default.htm
  Todo.php
```
Код конструктора vue-компонента можно разместить в файле разметки default.htm в тегах <script></script> или в отдельном файле, но тогда нужно подключить его в php-файле компонента с помощью функции addJs:
```
  public function onRun()
  {
      $this->addJs('components/todo/Todo.vue.js');
  }
```
Создадим конструктор vue-компонента в отдельном файле.

### Vue-компонент: Todo.vue.js

В папке компонента /todo создадим файл Todo.vue.js в котором создадим конструктор Vue-компонента списка дел (Todo): 
```
  var Todo = Vue.extend({
      props: {
          tasks: {
              coerce: function (val) {
                  return JSON.parse(val);
              }
          },
      },
      data: function() {
          return {
              title: 'To Do List',
              newTask: '',
            };
      },
      methods: {
          addTask: function() {
              var self = this;
              $.request("onAddTask", {
                  data: {
                      newTask: self.newTask,
                  },
                  success: function(data) {
                      self.tasks.push(data.newTask);
                      self.newTask = '';
                  },
              });
          },
          deleteTask: function(task_id) {
              var self = this;
              $.request("onDeleteTask", {
                  data: {
                      task_id: task_id
                  },
                  success: function() {
                      self.tasks = self.tasks
                          .filter(function (el) {
                                return el.id !== task_id;
                           }
                      );
                  }
              });
          }
      }
  }); 
```
Нужно присвоить конструктор компонента в переменную. Эту переменную необходимо указать в php-файле в public свойстве $vueComponents в качестве элемента массива (см код Todo.php). 

### Шаблон компонента: default.htm

В файле /todo/default.htm поместим разметку компонента:
```
  <todo
      inline-template
      tasks='{{ tasks|json_encode() }}'
  >
      {% verbatim %}
      <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title">{{title}}</h3>
          </div>
          <div class="panel-body">
              <form v-on:submit.prevent="addTask">
                  <div class="form-group col-md-11">
                      <input type="text" id="input-item" class="form-control" name="title" placeholder="What needs to be done?" v-model="newTask">
                  </div>
                  <button
                      type="submit"
                      class="btn btn btn-primary col-md-1"
                  >
                      Add
                  </button>
              </form>
          </div>
          <ul class="list-group" id="result">
              <li class="list-group-item" v-for="task in tasks">
  
                  {{task.title}}
  
                  <button type="button"
                      class="close pull-right"
                      aria-hidden="true"
                      v-on:click="deleteTask(task.id)">&times;</button>
              </li>
          </ul>
      </div>
      {% endverbatim %}
  </todo>
```
В файл разметки  помещается шаблон Vue-компонента. Опция inline-template позволяет разместить шаблон прямо внутри тегов. 
Исходные данные передаются через свойства (Props) vue-компонента. Если в свойстве передается объект, то его нужно использовать приведение типов (см. код Todo.vue.js). 
Разметка vue-компонента обрамляется в теги {% verbatim %}{% endverbatim %}, чтобы не было конфликта с Twig.

### Backend часть: Todo.php

В файле Todo.php поместим backend-код нашего компонента:
```
  class Todo extends ComponentBase
  {
  
      public $vueComponents = ['Todo'];
  
      public function componentDetails()
      {
          return [
              'name'        => 'Todo List',
              'description' => 'Implements a simple to-do list.'
          ];
      }
  
      public function onRun()
      {
          $this->addJs('components/todo/Todo.vue.js');
          $this->page['tasks'] = Task::all();
      }
  
      public function onAddTask()
      {
          if (($newTask = post('newTask')) != '') {
              $task = new Task;
              $task->title = $newTask;
              $task->save();
              return [ 'newTask' => $task];
          } else {
              throw new \ValidationException(['newTask' => 'Task can not be empty'], 1);
          }
      }
  
      public function onDeleteTask()
      {
          if ($task_id = post('task_id')) {
              Task::destroy($task_id);
          }
      }
  }
```
Php файл-класс компонента используется в качестве бэкенд-части. В нем необходимо объявить какие vue-компоненты использованы в разметке october-компонента `(public $vueComponents = ['Todo'];)`, внедрить javascript файлы, в которых эти vue-компоненты определены `($this->addJs('components/todo/Todo.vue.js');)`. В нем же размещаются обработчики ajax-запросов от vue-компонентов `(onAddTask(), onDeleteTask())`.  

В свойстве `$vueComponents` можно указать либо обычный массив - список компонентов: `public $vueComponents = ['Component1’, ‘Component2’, ‘Component3’'];` или ассоциативный массив в формате `public $vueComponents = ['tag’ => ‘Constructor name’];`  Если тэг не задан, то он будет сформирован из названия класса в стиле “все буквы строчные, слова разделяются дифисами”. 

