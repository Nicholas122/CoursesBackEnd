(function(t){function e(e){for(var n,r,o=e[0],u=e[1],c=e[2],l=0,v=[];l<o.length;l++)r=o[l],i[r]&&v.push(i[r][0]),i[r]=0;for(n in u)Object.prototype.hasOwnProperty.call(u,n)&&(t[n]=u[n]);d&&d(e);while(v.length)v.shift()();return a.push.apply(a,c||[]),s()}function s(){for(var t,e=0;e<a.length;e++){for(var s=a[e],n=!0,o=1;o<s.length;o++){var u=s[o];0!==i[u]&&(n=!1)}n&&(a.splice(e--,1),t=r(r.s=s[0]))}return t}var n={},i={1:0},a=[];function r(e){if(n[e])return n[e].exports;var s=n[e]={i:e,l:!1,exports:{}};return t[e].call(s.exports,s,s.exports,r),s.l=!0,s.exports}r.m=t,r.c=n,r.d=function(t,e,s){r.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:s})},r.r=function(t){Object.defineProperty(t,"__esModule",{value:!0})},r.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return r.d(e,"a",e),e},r.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},r.p="/";var o=window["webpackJsonp"]=window["webpackJsonp"]||[],u=o.push.bind(o);o.push=e,o=o.slice();for(var c=0;c<o.length;c++)e(o[c]);var d=u;a.push([2,0]),s()})({2:function(t,e,s){t.exports=s("Vtdi")},"H+bw":function(t,e,s){},Pf3K:function(t,e,s){"use strict";var n=s("hq8o"),i=s("QtiU"),a=(s("ZL7j"),s("KHd+")),r=Object(a["a"])(i["default"],n["a"],n["b"],!1,null,null,null);e["default"]=r.exports},QtiU:function(t,e,s){"use strict";var n=s("UHOq"),i=s.n(n);e["default"]=i.a},UHOq:function(t,e){},Vtdi:function(t,e,s){"use strict";s.r(e);var n={};s.d(n,"fetchTest",function(){return A}),s.d(n,"fetchQuestion",function(){return q}),s.d(n,"startTest",function(){return T}),s.d(n,"changeActiveQuestion",function(){return y}),s.d(n,"finishTest",function(){return Q}),s.d(n,"updateSubQuestionId",function(){return I});var i={};s.d(i,"USER_INPUT",function(){return N}),s.d(i,"MULTIPLE_CHOICE",function(){return j}),s.d(i,"READING_TEXT",function(){return L});s("VRzm");var a,r=s("Kw5r"),o=s("Pf3K"),u=(s("dRSK"),s("L2JU")),c="SET_TEST_DATA",d="SET_QUESTION_DATA",l="START_TEST",v="CHANGE_ACTIVE_QUESTION",f="FINISH_TEST",m="UPDATE_QUESTION_ANSWER",p="UPDATE_SUBQUESTION_ID",h=s("vDqi"),_=s.n(h),C=_.a.create({baseURL:"/api/"}),w=function(t){return C.get("/test/".concat(t))},g=function(t){return C.get("/questions?test=".concat(t)).then(function(t){var e=t.data;return e})},b=function(t){return C.post("/test/pass",t).then(function(t){return t.data})},A=function(t,e){var s=t.commit;return w(e).then(function(t){return s(c,t)})},q=function(t,e){var s=t.commit;return g(e).then(function(t){return s(d,t)})},T=function(t){var e=t.commit;return e(l)},y=function(t,e){var s=t.commit;return s(v,e)},Q=function(t,e){var s=t.commit;return b({answers:e}).then(function(t){return s(f,t)})},I=function(t,e){var s=t.commit;return s(p,e)},x=s("oyJW"),E=(a={},Object(x["a"])(a,c,function(t,e){t.courseId=e.data.section.course.id,t.test.data.title=e.data.title,t.test.data.description=e.data.description,t.test.data.section=e.data.section,t.test.data.timeLimit=e.data.timeLimit,t.test.data.passingScorePercent=e.data.passingScorePercent,t.test.data.retakeTimeout=e.data.retakeTimeout}),Object(x["a"])(a,d,function(t,e){t.questions=e,t.activeQuestion=e[0]}),Object(x["a"])(a,l,function(t){t.test.started=!0}),Object(x["a"])(a,v,function(t,e){t.activeQuestion=t.questions.find(function(t){return t.id===e})}),Object(x["a"])(a,f,function(t){t.test.started=!1,t.test.passed=!0}),Object(x["a"])(a,m,function(t,e){var s=t.answers.find(function(e){return e.questionId===t.activeQuestion.id});s?s.value=e:t.answers.push({questionId:t.activeQuestion.id,value:e})}),a);r["a"].use(u["a"]);var O={test:{fetching:!1,creating:!1,error:!1,errors:{},started:!1,passed:!1,data:{title:"",questions:[],description:"",section:"",timeLimit:"",passingScorePercent:60,retakeTimeout:""}},questions:[],activeQuestion:{},answers:[],subQuestionId:0,result:{}},D=new u["a"].Store({state:O,mutations:E,actions:n,getters:{getAnswerValue:function(t){var e=t.answers.find(function(e){return e.questionId===t.activeQuestion.id}),s=[];return"USER_INPUT"==t.activeQuestion.type&&(s=""),e&&(s=e.value),s}}}),S=s("jE9Z"),P=function(){var t=this,e=t.$createElement,s=t._self._c||e;return 0==t.testData.started&&0==t.testData.passed?s("div",{staticClass:"container theme-showcase"},[s("div",{staticClass:"starter-template"},[s("div",{staticClass:"page-header"},[s("div",{staticClass:"row my-header"},[s("h1",{staticClass:"col-sm-4"},[t._v(t._s(t.testData.data.title))])])])]),t._v(" "),s("div",{staticClass:"container "},[s("div",{staticClass:"myTestContainer"},[s("div",{staticClass:"testDescription"},[s("h3",[t._v(t._s(t.testData.data.description))])]),t._v(" "),s("div",{staticClass:"form-group startTest"},[s("button",{staticClass:"btn btn-primary btn-lg",on:{click:function(e){return e.preventDefault(),t.startTest(e)}}},[t._v("Start test")])])])])]):t.testData.started?s("div",{staticClass:"container theme-showcase"},[s("div",{staticClass:"starter-template"},[s("div",{staticClass:"page-header"},[s("div",{staticClass:"row my-header"},[s("h1",{staticClass:"col-sm-4"},[t._v(t._s(t.testData.data.title))]),t._v(" "),s("div",{staticClass:"col-xs-4 timer"},[s("vue-countdown",{attrs:{seconds:t.testData.data.timeLimit,start:!0},on:{"time-expire":t.saveTest}})],1)])]),t._v(" "),s("div",{staticClass:"container "},[s("div",{staticClass:"myTestContainer"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-6"},t._l(t.questions,function(e,n){return s("div",{key:e.id,attrs:{id:"calendarPagination"}},[s("div",{class:["pagination","btn","btn-default","currentQuestion",{active:t.activeQuestion.id==e.id}]},[s("a",{attrs:{href:"#"},on:{click:function(s){s.preventDefault(),t.changeActiveQuestion(e.id)}}},[t._v(t._s(n+1))])])])})),t._v(" "),t._m(0)]),t._v(" "),s("div",{attrs:{id:"questionContainer"}},[s("div",{staticClass:"questions"},[s("h2",{staticClass:"qHeader"},[t._v("Question "+t._s(t.getCurrentQuestionIndex()+1)+" outof "+t._s(t.questions.length)+" ")]),t._v(" "),s("div",{staticClass:"rtDescription"},[s("h3",[s("p",[t._v(t._s(t.activeQuestion.text))])])])]),t._v(" "),"USER_INPUT"==t.activeQuestion.type?s("div",{staticClass:"form-horizontal answerContainers"},[s("div",{staticClass:"form-group"},[s("textarea",{directives:[{name:"model",rawName:"v-model",value:t.questionAnswer,expression:"questionAnswer"}],staticClass:"form-control userInputAnswers results",attrs:{placeholder:"Please enter your answers here"},domProps:{value:t.questionAnswer},on:{input:function(e){e.target.composing||(t.questionAnswer=e.target.value)}}})])]):"MULTIPLE_CHOICE"==t.activeQuestion.type?s("div",{staticClass:"form-horizontal answerContainers"},t._l(t.activeQuestion.answers,function(e){return s("div",{key:e.id,staticClass:"answers"},[s("div",{staticClass:"form-group answerLines"},[s("div",{staticClass:"col-sm-1 multiAnswers"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.questionAnswer,expression:"questionAnswer"}],staticClass:"results input-answer",attrs:{type:"checkbox"},domProps:{value:e.id,checked:Array.isArray(t.questionAnswer)?t._i(t.questionAnswer,e.id)>-1:t.questionAnswer},on:{change:function(s){var n=t.questionAnswer,i=s.target,a=!!i.checked;if(Array.isArray(n)){var r=e.id,o=t._i(n,r);i.checked?o<0&&(t.questionAnswer=n.concat([r])):o>-1&&(t.questionAnswer=n.slice(0,o).concat(n.slice(o+1)))}else t.questionAnswer=a}}})]),t._v(" "),s("div",{staticClass:"col-sm-10 answerDescriptions"},[t._v(" \n\t\t\t\t\t\t\t\t\t"+t._s(e.text)+" \n\t\t\t\t\t\t\t\t")])])])})):"READING_TEXT"==t.activeQuestion.type?s("div",{staticClass:"form-horizontal answerContainers"},[s("div",{staticClass:"reading-text-info"},[s("p",[t._v(t._s(t.activeQuestion.readingText))])]),t._v(" "),t._m(1),t._v(" "),t._l(t.activeQuestion.subQuestions,function(e,n){return s("div",{key:e.id,staticClass:"reading-text-subquestions"},[s("h4",[t._v("Question "+t._s(n+1))]),t._v(" "),s("p",[t._v(t._s(e.text))]),t._v(" "),t._l(e.answers,function(n){return s("div",{key:n.id,staticClass:"reading-text-subquestions-answers"},[s("div",{staticClass:"form-group answerLines"},[s("div",{staticClass:"col-sm-1 multiAnswers"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.questionAnswer,expression:"questionAnswer"}],staticClass:"results input-answer",attrs:{type:"checkbox"},domProps:{value:n.id+"|"+e.id,checked:Array.isArray(t.questionAnswer)?t._i(t.questionAnswer,n.id+"|"+e.id)>-1:t.questionAnswer},on:{change:function(s){var i=t.questionAnswer,a=s.target,r=!!a.checked;if(Array.isArray(i)){var o=n.id+"|"+e.id,u=t._i(i,o);a.checked?u<0&&(t.questionAnswer=i.concat([o])):u>-1&&(t.questionAnswer=i.slice(0,u).concat(i.slice(u+1)))}else t.questionAnswer=r}}})]),t._v(" "),s("div",{staticClass:"col-sm-10 answerDescriptions"},[t._v(" \n\t\t\t\t\t\t\t\t\t\t"+t._s(n.text)+" \n\t\t\t\t\t\t\t\t\t")])])])})],2)})],2):t._e()])]),t._v(" "),s("ul",{staticClass:"pager",attrs:{id:"prevNextBtn"}},[t.getPreviousQuestionId()?s("li",{staticClass:"previous"},[s("a",{staticClass:"btn-link",attrs:{type:"button"},on:{click:function(e){e.preventDefault(),t.changeActiveQuestion(t.getPreviousQuestionId())}}},[t._v("Previous")])]):t._e(),t._v(" "),t.getNextQuestionId()?s("li",{staticClass:"next"},[s("a",{staticClass:"btn-link",attrs:{type:"button"},on:{click:function(e){e.preventDefault(),t.changeActiveQuestion(t.getNextQuestionId())}}},[t._v("Next")])]):t._e()])])]),t._v(" "),s("div",{staticClass:"modal fade",staticStyle:{display:"none"},attrs:{id:"finishConfirmation",tabindex:"-1",role:"dialog","aria-labelledby":"deleteConfirmationLabel","aria-hidden":"true"}},[s("div",{staticClass:"modal-dialog"},[s("div",{staticClass:"modal-content"},[t._m(2),t._v(" "),s("div",{staticClass:"modal-body"},[t._v("Are you sure you want to finish?")]),t._v(" "),s("div",{staticClass:"modal-footer"},[s("button",{staticClass:"btn btn-primary confirm-finishing",attrs:{type:"button","data-dismiss":"modal"},on:{click:function(e){return e.preventDefault(),t.saveTest(e)}}},[t._v("Finish")]),t._v(" "),s("button",{staticClass:"btn btn-default",attrs:{type:"button","data-dismiss":"modal"}},[t._v("Cancel")])])])])])]):t.testData.passed?s("div",{staticClass:"container theme-showcase"},[t._m(3)]):t._e()},k=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-md-6"},[s("div",{staticClass:"finish-btn clearfix"},[s("button",{staticClass:"btn-link",attrs:{type:"button",id:"finishTest","data-toggle":"modal","data-target":"#finishConfirmation"}},[t._v("Finish")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("h3",[s("strong",[t._v("Questions:")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"modal-header"},[s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-hidden":"true"}},[t._v("×")]),t._v(" "),s("h4",{staticClass:"modal-title",attrs:{id:"finishConfirmationLabel"}},[t._v("Confirm your finishing")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"starter-template"},[s("div",{staticClass:"page-header"},[s("div",{staticClass:"row my-header"},[s("h1",{staticClass:"col-sm-4"},[t._v("Results: 100%")])])]),t._v(" "),s("div",{staticClass:"container"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-md-6"},[s("p",[t._v("Test passed!")])])])])])}],U=(s("INYr"),s("yT7P")),N="User input",j="Multiple choice",L="Reading text",H=s("2DyF"),R=s.n(H),V={props:["testId"],components:{"vue-countdown":R.a},created:function(){this.fetchTest(this.testId),this.fetchQuestion(this.testId)},computed:Object(U["a"])({},Object(u["c"])(["getAnswerValue"]),Object(u["d"])({testData:function(t){return t.test},questions:function(t){return t.questions},activeQuestion:function(t){return t.activeQuestion},answers:function(t){return t.answers}}),{questionAnswer:{get:function(){return this.getAnswerValue},set:function(t){this.$store.commit("UPDATE_QUESTION_ANSWER",t)}}}),methods:Object(U["a"])({},Object(u["b"])(["fetchTest","fetchQuestion","startTest","changeActiveQuestion","finishTest"]),{getConst:function(t){return i[t]},getCurrentQuestionIndex:function(){var t=this;return this.questions.findIndex(function(e){return e.id===t.activeQuestion.id})},getPreviousQuestionId:function(){var t=this.getCurrentQuestionIndex(),e=!1;return this.questions[t-1]&&(e=this.questions[t-1].id),e},getNextQuestionId:function(){var t=this.getCurrentQuestionIndex(),e=!1;return this.questions[t+1]&&(e=this.questions[t+1].id),e},saveTest:function(){this.finishTest(this.answers)}})},$=V,K=(s("gBIe"),s("KHd+")),M=Object(K["a"])($,P,k,!1,null,null,null),z=M.exports;r["a"].use(S["a"]);var B=new S["a"]({mode:"history",routes:[{path:"/test/:testId",component:z,props:!0}]});new r["a"]({el:"#app",router:B,store:D,render:function(t){return t(o["default"])}})},ZL7j:function(t,e,s){"use strict";var n=s("qHOS"),i=s.n(n);i.a},gBIe:function(t,e,s){"use strict";var n=s("H+bw"),i=s.n(n);i.a},hq8o:function(t,e,s){"use strict";var n=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("router-view")},i=[];s.d(e,"a",function(){return n}),s.d(e,"b",function(){return i})},qHOS:function(t,e,s){}});
//# sourceMappingURL=app.7f50347f.js.map