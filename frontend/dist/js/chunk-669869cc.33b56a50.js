(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-669869cc"],{"0a6d":function(e,t,i){"use strict";i.r(t);var a=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-row",{staticClass:"match-height"},[i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-card",[i("v-card-title",[e._v("Horizontal Form")]),i("v-card-text",[i("demo-form-layout-horizontal")],1)],1)],1),i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-card",[i("v-card-title",[e._v("Horizontal Form with Icons")]),i("v-card-text",[i("demo-form-layout-horizontal-icon")],1)],1)],1),i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-card",[i("v-card-title",[e._v("Vertical Form")]),i("v-card-text",[i("demo-form-layout-vertical-form")],1)],1)],1),i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-card",[i("v-card-title",[e._v("Vertical Form with Icons")]),i("v-card-text",[i("demo-form-layout-vertical-form-with-icons")],1)],1)],1),i("v-col",{attrs:{cols:"12"}},[i("v-card",[i("v-card-title",[e._v("Multiple Column")]),i("v-card-text",[i("demo-form-layout-multiple-column")],1)],1)],1)],1)},l=[],o=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-form",[i("v-row",[i("v-col",{attrs:{cols:"12",md:"3"}},[i("label",{attrs:{for:"firstname"}},[e._v("First Name")])]),i("v-col",{attrs:{cols:"12",md:"9"}},[i("v-text-field",{attrs:{id:"firstname",outlined:"",dense:"",placeholder:"First Name","hide-details":""},model:{value:e.firstname,callback:function(t){e.firstname=t},expression:"firstname"}})],1),i("v-col",{attrs:{cols:"12",md:"3"}},[i("label",{attrs:{for:"email"}},[e._v("Email")])]),i("v-col",{attrs:{cols:"12",md:"9"}},[i("v-text-field",{attrs:{id:"email",outlined:"",dense:"",placeholder:"Email","hide-details":""},model:{value:e.email,callback:function(t){e.email=t},expression:"email"}})],1),i("v-col",{attrs:{cols:"12",md:"3"}},[i("label",{attrs:{for:"mobile"}},[e._v("Mobile")])]),i("v-col",{attrs:{cols:"12",md:"9"}},[i("v-text-field",{attrs:{id:"mobile",type:"number",outlined:"",dense:"",placeholder:"Number","hide-details":""},model:{value:e.mobile,callback:function(t){e.mobile=t},expression:"mobile"}})],1),i("v-col",{attrs:{cols:"12",md:"3"}},[i("label",{attrs:{for:"password"}},[e._v("Password")])]),i("v-col",{attrs:{cols:"12",md:"9"}},[i("v-text-field",{attrs:{id:"password",type:"password",outlined:"",dense:"",placeholder:"Password","hide-details":""},model:{value:e.password,callback:function(t){e.password=t},expression:"password"}})],1),i("v-col",{attrs:{"offset-md":"3",cols:"12"}},[i("v-checkbox",{staticClass:"mt-0",attrs:{label:"Remember me","hide-details":""},model:{value:e.checkbox,callback:function(t){e.checkbox=t},expression:"checkbox"}})],1),i("v-col",{attrs:{"offset-md":"3",cols:"12"}},[i("v-btn",{attrs:{color:"primary"}},[e._v(" Submit ")]),i("v-btn",{staticClass:"mx-2",attrs:{type:"reset",outlined:""}},[e._v(" Reset ")])],1)],1)],1)},n=[],s=i("ed09"),r={setup:function(){var e=Object(s["e"])(""),t=Object(s["e"])(""),i=Object(s["e"])(),a=Object(s["e"])(),l=Object(s["e"])(!1);return{firstname:e,email:t,mobile:i,password:a,checkbox:l}}},c=r,d=i("2877"),u=i("6544"),m=i.n(u),h=i("8336"),p=i("ac7c"),v=i("62ad"),f=i("4bd4"),b=i("0fd9"),x=i("8654"),k=Object(d["a"])(c,o,n,!1,null,null,null),y=k.exports;m()(k,{VBtn:h["a"],VCheckbox:p["a"],VCol:v["a"],VForm:f["a"],VRow:b["a"],VTextField:x["a"]});var w=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-form",[i("v-row",[i("v-col",{attrs:{cols:"12",md:"3"}},[i("label",{attrs:{for:"firstnameHorizontalIcons"}},[e._v("First Name")])]),i("v-col",{attrs:{cols:"12",md:"9"}},[i("v-text-field",{attrs:{id:"firstnameHorizontalIcons","prepend-inner-icon":e.icons.mdiAccountOutline,outlined:"",dense:"",placeholder:"First Name","hide-details":""},model:{value:e.firstname,callback:function(t){e.firstname=t},expression:"firstname"}})],1),i("v-col",{attrs:{cols:"12",md:"3"}},[i("label",{attrs:{for:"emailHorizontalIcons"}},[e._v("Email")])]),i("v-col",{attrs:{cols:"12",md:"9"}},[i("v-text-field",{attrs:{id:"emailHorizontalIcons","prepend-inner-icon":e.icons.mdiEmailOutline,outlined:"",dense:"",placeholder:"Email","hide-details":""},model:{value:e.email,callback:function(t){e.email=t},expression:"email"}})],1),i("v-col",{attrs:{cols:"12",md:"3"}},[i("label",{attrs:{for:"mobileHorizontalIcons"}},[e._v("Mobile")])]),i("v-col",{attrs:{cols:"12",md:"9"}},[i("v-text-field",{attrs:{id:"mobileHorizontalIcons",type:"number",outlined:"","prepend-inner-icon":e.icons.mdiCellphone,dense:"",placeholder:"Number","hide-details":""},model:{value:e.mobile,callback:function(t){e.mobile=t},expression:"mobile"}})],1),i("v-col",{attrs:{cols:"12",md:"3"}},[i("label",{attrs:{for:"passwordHorizontalIcons"}},[e._v("Password")])]),i("v-col",{attrs:{cols:"12",md:"9"}},[i("v-text-field",{attrs:{id:"passwordHorizontalIcons","prepend-inner-icon":e.icons.mdiLockOutline,type:"password",outlined:"",dense:"",placeholder:"Password","hide-details":""},model:{value:e.password,callback:function(t){e.password=t},expression:"password"}})],1),i("v-col",{attrs:{"offset-md":"3",cols:"12"}},[i("v-checkbox",{staticClass:"mt-0",attrs:{label:"Remember me","hide-details":""},model:{value:e.checkbox,callback:function(t){e.checkbox=t},expression:"checkbox"}})],1),i("v-col",{attrs:{"offset-md":"3",cols:"12"}},[i("v-btn",{attrs:{color:"primary"}},[e._v(" Submit ")]),i("v-btn",{staticClass:"mx-2",attrs:{type:"reset",outlined:""}},[e._v(" Reset ")])],1)],1)],1)},V=[],C=i("94ed"),O={setup:function(){var e=Object(s["e"])(""),t=Object(s["e"])(""),i=Object(s["e"])(),a=Object(s["e"])(),l=Object(s["e"])(!1);return{firstname:e,email:t,mobile:i,password:a,checkbox:l,icons:{mdiAccountOutline:C["C"],mdiEmailOutline:C["nb"],mdiCellphone:C["P"],mdiLockOutline:C["Gb"]}}}},_=O,j=Object(d["a"])(_,w,V,!1,null,null,null),g=j.exports;m()(j,{VBtn:h["a"],VCheckbox:p["a"],VCol:v["a"],VForm:f["a"],VRow:b["a"],VTextField:x["a"]});var F=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-form",[i("v-text-field",{attrs:{label:"First Name",outlined:"",dense:"",placeholder:"First Name"},model:{value:e.firstname,callback:function(t){e.firstname=t},expression:"firstname"}}),i("v-text-field",{attrs:{label:"Email",type:"email",outlined:"",dense:"",placeholder:"Email"},model:{value:e.email,callback:function(t){e.email=t},expression:"email"}}),i("v-text-field",{attrs:{label:"Mobile",outlined:"",dense:"",type:"number",placeholder:"Number"},model:{value:e.mobile,callback:function(t){e.mobile=t},expression:"mobile"}}),i("v-text-field",{attrs:{label:"Password",outlined:"",dense:"",type:"password",placeholder:"password"},model:{value:e.password,callback:function(t){e.password=t},expression:"password"}}),i("v-checkbox",{staticClass:"mt-0",attrs:{label:"Remember me"},model:{value:e.checkbox,callback:function(t){e.checkbox=t},expression:"checkbox"}}),i("v-btn",{attrs:{color:"primary"}},[e._v(" Submit ")]),i("v-btn",{staticClass:"mx-2",attrs:{type:"reset",outlined:""}},[e._v(" Reset ")])],1)},I=[],E={setup:function(){var e=Object(s["e"])(""),t=Object(s["e"])(""),i=Object(s["e"])(),a=Object(s["e"])(),l=Object(s["e"])(!1);return{firstname:e,email:t,mobile:i,password:a,checkbox:l}}},$=E,B=Object(d["a"])($,F,I,!1,null,null,null),N=B.exports;m()(B,{VBtn:h["a"],VCheckbox:p["a"],VForm:f["a"],VTextField:x["a"]});var S=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-form",[i("v-text-field",{attrs:{"prepend-inner-icon":e.icons.mdiAccountOutline,label:"First Name",outlined:"",dense:"",placeholder:"First Name"},model:{value:e.firstname,callback:function(t){e.firstname=t},expression:"firstname"}}),i("v-text-field",{attrs:{"prepend-inner-icon":e.icons.mdiEmailOutline,label:"Email",type:"email",outlined:"",dense:"",placeholder:"Email"},model:{value:e.email,callback:function(t){e.email=t},expression:"email"}}),i("v-text-field",{attrs:{"prepend-inner-icon":e.icons.mdiCellphone,label:"Mobile",outlined:"",dense:"",type:"number",placeholder:"Number"},model:{value:e.mobile,callback:function(t){e.mobile=t},expression:"mobile"}}),i("v-text-field",{attrs:{"prepend-inner-icon":e.icons.mdiLockOutline,label:"Password",outlined:"",dense:"",type:"password",placeholder:"password"},model:{value:e.password,callback:function(t){e.password=t},expression:"password"}}),i("v-checkbox",{staticClass:"mt-0",attrs:{label:"Remember me"},model:{value:e.checkbox,callback:function(t){e.checkbox=t},expression:"checkbox"}}),i("v-btn",{attrs:{color:"primary"}},[e._v(" Submit ")]),i("v-btn",{staticClass:"mx-2",attrs:{type:"reset",outlined:""}},[e._v(" Reset ")])],1)},z=[],A={setup:function(){var e=Object(s["e"])(""),t=Object(s["e"])(""),i=Object(s["e"])(),a=Object(s["e"])(),l=Object(s["e"])(!1);return{firstname:e,email:t,mobile:i,password:a,checkbox:l,icons:{mdiAccountOutline:C["C"],mdiEmailOutline:C["nb"],mdiCellphone:C["P"],mdiLockOutline:C["Gb"]}}}},R=A,L=Object(d["a"])(R,S,z,!1,null,null,null),D=L.exports;m()(L,{VBtn:h["a"],VCheckbox:p["a"],VForm:f["a"],VTextField:x["a"]});var H=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-form",{staticClass:"multi-col-validation"},[i("v-row",[i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-text-field",{attrs:{label:"First Name",outlined:"",dense:"",placeholder:"First Name","hide-details":""},model:{value:e.firstName,callback:function(t){e.firstName=t},expression:"firstName"}})],1),i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-text-field",{attrs:{label:"Last Name",outlined:"",dense:"",placeholder:"Last Name","hide-details":""},model:{value:e.lastName,callback:function(t){e.lastName=t},expression:"lastName"}})],1),i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-text-field",{attrs:{label:"Email",outlined:"",dense:"",placeholder:"Email","hide-details":""},model:{value:e.email,callback:function(t){e.email=t},expression:"email"}})],1),i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-text-field",{attrs:{label:"City",outlined:"",dense:"",placeholder:"City","hide-details":""},model:{value:e.city,callback:function(t){e.city=t},expression:"city"}})],1),i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-text-field",{attrs:{label:"Country",outlined:"",dense:"",placeholder:"Country","hide-details":""},model:{value:e.country,callback:function(t){e.country=t},expression:"country"}})],1),i("v-col",{attrs:{cols:"12",md:"6"}},[i("v-text-field",{attrs:{label:"Company",outlined:"",dense:"",placeholder:"Company","hide-details":""},model:{value:e.company,callback:function(t){e.company=t},expression:"company"}})],1),i("v-col",{attrs:{cols:"12"}},[i("v-checkbox",{staticClass:"mt-0",attrs:{label:"Remember me","hide-details":""},model:{value:e.checkbox,callback:function(t){e.checkbox=t},expression:"checkbox"}})],1),i("v-col",{attrs:{cols:"12"}},[i("v-btn",{attrs:{color:"primary"}},[e._v(" Submit ")]),i("v-btn",{staticClass:"mx-2",attrs:{type:"reset",outlined:""}},[e._v(" Reset ")])],1)],1)],1)},T=[],P={setup:function(){var e=Object(s["e"])(""),t=Object(s["e"])(""),i=Object(s["e"])(""),a=Object(s["e"])(""),l=Object(s["e"])(""),o=Object(s["e"])(""),n=Object(s["e"])(!1);return{firstName:e,lastName:t,city:i,country:a,company:l,email:o,checkbox:n}}},M=P,G=Object(d["a"])(M,H,T,!1,null,null,null),J=G.exports;m()(G,{VBtn:h["a"],VCheckbox:p["a"],VCol:v["a"],VForm:f["a"],VRow:b["a"],VTextField:x["a"]});var K={components:{DemoFormLayoutHorizontal:y,DemoFormLayoutHorizontalIcon:g,DemoFormLayoutVerticalForm:N,DemoFormLayoutVerticalFormWithIcons:D,DemoFormLayoutMultipleColumn:J},setup:function(){return{}}},W=K,q=i("b0af"),Q=i("99d9"),U=Object(d["a"])(W,a,l,!1,null,null,null);t["default"]=U.exports;m()(U,{VCard:q["a"],VCardText:Q["c"],VCardTitle:Q["d"],VCol:v["a"],VRow:b["a"]})},"4bd4":function(e,t,i){"use strict";var a=i("5530"),l=(i("caad"),i("2532"),i("07ac"),i("4de4"),i("159b"),i("7db0"),i("58df")),o=i("7e2b"),n=i("3206");t["a"]=Object(l["a"])(o["a"],Object(n["b"])("form")).extend({name:"v-form",provide:function(){return{form:this}},inheritAttrs:!1,props:{disabled:Boolean,lazyValidation:Boolean,readonly:Boolean,value:Boolean},data:function(){return{inputs:[],watchers:[],errorBag:{}}},watch:{errorBag:{handler:function(e){var t=Object.values(e).includes(!0);this.$emit("input",!t)},deep:!0,immediate:!0}},methods:{watchInput:function(e){var t=this,i=function(e){return e.$watch("hasError",(function(i){t.$set(t.errorBag,e._uid,i)}),{immediate:!0})},a={_uid:e._uid,valid:function(){},shouldValidate:function(){}};return this.lazyValidation?a.shouldValidate=e.$watch("shouldValidate",(function(l){l&&(t.errorBag.hasOwnProperty(e._uid)||(a.valid=i(e)))})):a.valid=i(e),a},validate:function(){return 0===this.inputs.filter((function(e){return!e.validate(!0)})).length},reset:function(){this.inputs.forEach((function(e){return e.reset()})),this.resetErrorBag()},resetErrorBag:function(){var e=this;this.lazyValidation&&setTimeout((function(){e.errorBag={}}),0)},resetValidation:function(){this.inputs.forEach((function(e){return e.resetValidation()})),this.resetErrorBag()},register:function(e){this.inputs.push(e),this.watchers.push(this.watchInput(e))},unregister:function(e){var t=this.inputs.find((function(t){return t._uid===e._uid}));if(t){var i=this.watchers.find((function(e){return e._uid===t._uid}));i&&(i.valid(),i.shouldValidate()),this.watchers=this.watchers.filter((function(e){return e._uid!==t._uid})),this.inputs=this.inputs.filter((function(e){return e._uid!==t._uid})),this.$delete(this.errorBag,t._uid)}}},render:function(e){var t=this;return e("form",{staticClass:"v-form",attrs:Object(a["a"])({novalidate:!0},this.attrs$),on:{submit:function(e){return t.$emit("submit",e)}}},this.$slots.default)}})},5311:function(e,t,i){"use strict";var a=i("5607"),l=i("2b0e");t["a"]=l["a"].extend({name:"rippleable",directives:{ripple:a["a"]},props:{ripple:{type:[Boolean,Object],default:!0}},methods:{genRipple:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return this.ripple?(e.staticClass="v-input--selection-controls__ripple",e.directives=e.directives||[],e.directives.push({name:"ripple",value:{center:!0}}),this.$createElement("div",e)):null}}})},"6ca7":function(e,t,i){},8547:function(e,t,i){"use strict";var a=i("2b0e"),l=i("80d2");t["a"]=a["a"].extend({name:"comparable",props:{valueComparator:{type:Function,default:l["j"]}}})},ac7c:function(e,t,i){"use strict";var a=i("15fd"),l=i("5530"),o=(i("d3b7"),i("25f0"),i("6ca7"),i("ec29"),i("9d26")),n=i("c37a"),s=i("fe09"),r=["title"];t["a"]=s["a"].extend({name:"v-checkbox",props:{indeterminate:Boolean,indeterminateIcon:{type:String,default:"$checkboxIndeterminate"},offIcon:{type:String,default:"$checkboxOff"},onIcon:{type:String,default:"$checkboxOn"}},data:function(){return{inputIndeterminate:this.indeterminate}},computed:{classes:function(){return Object(l["a"])(Object(l["a"])({},n["a"].options.computed.classes.call(this)),{},{"v-input--selection-controls":!0,"v-input--checkbox":!0,"v-input--indeterminate":this.inputIndeterminate})},computedIcon:function(){return this.inputIndeterminate?this.indeterminateIcon:this.isActive?this.onIcon:this.offIcon},validationState:function(){if(!this.isDisabled||this.inputIndeterminate)return this.hasError&&this.shouldValidate?"error":this.hasSuccess?"success":null!==this.hasColor?this.computedColor:void 0}},watch:{indeterminate:function(e){var t=this;this.$nextTick((function(){return t.inputIndeterminate=e}))},inputIndeterminate:function(e){this.$emit("update:indeterminate",e)},isActive:function(){this.indeterminate&&(this.inputIndeterminate=!1)}},methods:{genCheckbox:function(){var e=this.attrs$,t=(e.title,Object(a["a"])(e,r));return this.$createElement("div",{staticClass:"v-input--selection-controls__input"},[this.$createElement(o["a"],this.setTextColor(this.validationState,{props:{dense:this.dense,dark:this.dark,light:this.light}}),this.computedIcon),this.genInput("checkbox",Object(l["a"])(Object(l["a"])({},t),{},{"aria-checked":this.inputIndeterminate?"mixed":this.isActive.toString()})),this.genRipple(this.setTextColor(this.rippleState))])},genDefaultSlot:function(){return[this.genCheckbox(),this.genLabel()]}}})},ec29:function(e,t,i){},fe09:function(e,t,i){"use strict";i.d(t,"b",(function(){return s}));i("d3b7"),i("25f0"),i("4de4");var a=i("c37a"),l=i("5311"),o=i("8547"),n=i("58df");function s(e){e.preventDefault()}t["a"]=Object(n["a"])(a["a"],l["a"],o["a"]).extend({name:"selectable",model:{prop:"inputValue",event:"change"},props:{id:String,inputValue:null,falseValue:null,trueValue:null,multiple:{type:Boolean,default:null},label:String},data:function(){return{hasColor:this.inputValue,lazyValue:this.inputValue}},computed:{computedColor:function(){if(this.isActive)return this.color?this.color:this.isDark&&!this.appIsDark?"white":"primary"},isMultiple:function(){return!0===this.multiple||null===this.multiple&&Array.isArray(this.internalValue)},isActive:function(){var e=this,t=this.value,i=this.internalValue;return this.isMultiple?!!Array.isArray(i)&&i.some((function(i){return e.valueComparator(i,t)})):void 0===this.trueValue||void 0===this.falseValue?t?this.valueComparator(t,i):Boolean(i):this.valueComparator(i,this.trueValue)},isDirty:function(){return this.isActive},rippleState:function(){return this.isDisabled||this.validationState?this.validationState:void 0}},watch:{inputValue:function(e){this.lazyValue=e,this.hasColor=e}},methods:{genLabel:function(){var e=a["a"].options.methods.genLabel.call(this);return e?(e.data.on={click:s},e):e},genInput:function(e,t){return this.$createElement("input",{attrs:Object.assign({"aria-checked":this.isActive.toString(),disabled:this.isDisabled,id:this.computedId,role:e,type:e},t),domProps:{value:this.value,checked:this.isActive},on:{blur:this.onBlur,change:this.onChange,focus:this.onFocus,keydown:this.onKeydown,click:s},ref:"input"})},onBlur:function(){this.isFocused=!1},onClick:function(e){this.onChange(),this.$emit("click",e)},onChange:function(){var e=this;if(this.isInteractive){var t=this.value,i=this.internalValue;if(this.isMultiple){Array.isArray(i)||(i=[]);var a=i.length;i=i.filter((function(i){return!e.valueComparator(i,t)})),i.length===a&&i.push(t)}else i=void 0!==this.trueValue&&void 0!==this.falseValue?this.valueComparator(i,this.trueValue)?this.falseValue:this.trueValue:t?this.valueComparator(i,t)?null:t:!i;this.validate(!0,i),this.internalValue=i,this.hasColor=i}},onFocus:function(){this.isFocused=!0},onKeydown:function(e){}}})}}]);
//# sourceMappingURL=chunk-669869cc.33b56a50.js.map