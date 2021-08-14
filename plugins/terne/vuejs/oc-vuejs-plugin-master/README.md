# Vue.js Plugin
Tools useful for creating websites with Vue.js and OctoberCMS. Inspired by AngularJS Plugin by “Responsiv”.

## Installation

- Create /plugins/terne/vuejs folder
- Extract source code in created folder
- run command `php artisan october:up` or just re-login to the backend.

## High level design consideration
Vue.js is a library for building interactive web interfaces. It provides data-reactive components with a simple and flexible API.

With this plugin you can do the following:
- Create a complete Single Page Application (SPA).
- Create AJAX-enabled sections of the website that behave like SPA (AJAX sections).
- Leverage Vue.js for your front-end templating.

When using this plugin in October, the page layout acts as the entry page. This allows a website to act as multiple SPAs and also as a traditional website. A complete SPA website should use just one layout, whereas a hybrid website could use a layout for each AJAX section along with layouts for the traditional pages.

## Create SPA.
### SPA Layout

Entry point for SPA can be either website's home page or inner page. For entry point page you should create layout and attach Layout component. Simple example of vue app entry point below:

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
Layout component must be included after jquery, `{% scripts %}` and `{% framework extras %}`.

In component settings you can define root app element for Vue (element with id='app' by default).
To use Vue routing pluging it should be enabled in component setting. Layout should have `<router-view>` tag.

Links to other pages should be defined with Vue directives `v-link` and `v-link-active`.

In compnent setting there is also ability to set any Vue-router options.

### SPA Pages

After layout was created it should be attached to entry point page of SPA. For other SPA pages layout is needless. Their content will be uploaded to entry page layout.

The entry SPA page should use a base url, all other SPA pages must be prefixed with this url. So if the entry page URL is /submit then all other pages must have a url that starts with /submit, for example, /submit/step1, /submit/step2.

```
  layouts/
      submit.htm    <== description: Submission process

  pages/
      start.htm     <== url: /submit,        layout: submit
      step1.htm     <== url: /submit/step1,  layout: -
      step2.htm     <== url: /submit/step2,  layout: -
      finish.htm    <== url: /submit/finish, layout: -
```  
Pages can use components, partials, contents, add assets as usual.

## OctoberCMS Components with Vue.js

Lets see how to use Vue.js in OctoberCMS components with simple Todo component example. Assume that we created empty Todo component:
```
  /todo
      default.htm
  Todo.php
```
You can place Vue-component constructor code in default.htm file inside `<script></script>` or in separate file, but it needed to be included in component's php file with `addJs` function.
```
  public function onRun()
  {
      $this->addJs('components/todo/Todo.vue.js');
  }
```
Lets create vue-component constructor in separate file.

### Vue-component: Todo.vue.js

Lets create Todo.vue.js file inside /todo folder and place Todo vue-component constructor code there:
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
We assign component constructor to `Todo` variable. We must add it to php-file in public class property `$vueComponents` (see Todo.php below).

### Component Template: default.htm

Lets place component template in /todo/default.htm:
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
We pass data in template through vue-component Props.
Vue-component template should be wrapped by `{% verbatim %}{% endverbatim %}` tags to avoid conflicts with Twig.

### Component Backend: Todo.php

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
We should list all vue components in `$vueComponents` public property. Simple array of constructor variables can be used (`public $vueComponents = ['Component1’, ‘Component2’, ‘Component3’'];`) or array with keys: `public $vueComponents = ['tag’ => ‘Constructor name’];`. If simple array used tag will be transformed from constructor variable name as "all-lowercase, must contain a hyphen".
