!function(e){var t={};function n(a){if(t[a])return t[a].exports;var r=t[a]={i:a,l:!1,exports:{}};return e[a].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(a,r,function(t){return e[t]}.bind(null,r));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=6)}([function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){!function(){e.exports=this.wp.i18n}()},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t){!function(){e.exports=this.wp.blocks}()},function(e,t){!function(){e.exports=this.wp.blockEditor}()},function(e,t){!function(){e.exports=this.wp.data}()},function(e,t,n){"use strict";n.r(t);var a=n(0),r={};r.featuredCarousel=Object(a.createElement)("svg",{"aria-hidden":"true",focusable:"false","data-prefix":"fas","data-icon":"conveyor-belt-alt",class:"svg-inline--fa fa-conveyor-belt-alt fa-w-20",role:"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 640 512"},Object(a.createElement)("path",{fill:"currentColor",d:"M80 256h224c8.8 0 16-7.2 16-16V16c0-8.8-7.2-16-16-16H80c-8.8 0-16 7.2-16 16v224c0 8.8 7.2 16 16 16zm320 0h160c8.8 0 16-7.2 16-16V80c0-8.8-7.2-16-16-16H400c-8.8 0-16 7.2-16 16v160c0 8.8 7.2 16 16 16zm144 64H96c-53 0-96 43-96 96s43 96 96 96h448c53 0 96-43 96-96s-43-96-96-96zM128 448c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm192 0c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm192 0c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32z"})),r.faqs=Object(a.createElement)("svg",{"aria-hidden":"true",focusable:"false","data-prefix":"fas","data-icon":"question-square",class:"svg-inline--fa fa-question-square fa-w-14",role:"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 448 512"},Object(a.createElement)("path",{fill:"currentColor",d:"M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM224 430c-25.365 0-46-20.636-46-46 0-25.365 20.635-46 46-46s46 20.635 46 46c0 25.364-20.635 46-46 46zm40-131.333V300c0 6.627-5.373 12-12 12h-56c-6.627 0-12-5.373-12-12v-4c0-41.059 31.128-57.472 54.652-70.66 20.171-11.309 32.534-19 32.534-33.976 0-19.81-25.269-32.958-45.698-32.958-27.19 0-39.438 13.139-57.303 35.797-4.045 5.13-11.46 6.069-16.665 2.122l-34.699-26.31c-5.068-3.843-6.251-10.972-2.715-16.258C141.4 112.957 176.158 90 230.655 90c56.366 0 116.531 43.998 116.531 102 0 77.02-83.186 78.205-83.186 106.667z"}));var c=r,o=n(3),l=n(1),s=n(4),i=n(5),u=n(2);Object(o.registerBlockType)("wyvern-plugin/faqs",{title:Object(l.__)("FAQs","wyvern-plugin"),icon:c.faqs,category:"wyvern-blocks",keywords:[Object(l.__)("FAQs","wyvern-plugin")],supports:{alignWide:!0,customClassName:!0,html:!1},getEditWrapperProps:function(e){return{"data-align":"full"}},edit:Object(i.withSelect)((function(e,t){var n=t.attributes.faqCategory;return 0===parseInt(n)&&(n=""),{faqCategories:e("core").getEntityRecords("taxonomy","wyvern_faq_categories",{per_page:-1}),selectedCategoryData:e("core").getEntityRecords("postType","wyvern_faqs",{per_page:-1,wyvern_faq_categories:n})}}))((function(e){var t,n=e.attributes,r=e.className,c=e.setAttributes,o=e.faqCategories,i=e.selectedCategoryData,f=n.faqCategory;return o?0===o.length?Object(a.createElement)("p",{className:"results"},Object(l.__)("No FAQ Categories found.","wyvern-plugin")):i?0===i.length?Object(a.createElement)("p",{className:"results"},Object(l.__)("No FAQs found.","wyvern-plugin")):(console.log(i),Object(a.createElement)("div",{className:"alignfull "+r},Object(a.createElement)(s.InspectorControls,null,Object(a.createElement)(u.PanelBody,{title:Object(l.__)("Select a FAQ Category","wyvern-plugin"),initialOpen:!0},Object(a.createElement)(u.SelectControl,{label:Object(l.__)("Selected FAQ Category","wyvern-plugin"),value:f,options:(t=o.map((function(e){var t={};return t.label=e.name,t.value=e.id,t})),t.unshift({label:"Display all FAQ Categories",value:0}),t),onChange:function(e){return c({faqCategory:e})}}))),Object(a.createElement)("div",{id:"faqs-"+Math.floor(100*Math.random()),className:"faqs-container accordion-container"},Object(a.createElement)("h2",{class:"faqs-block-header"},Object(l.__)("Frequently Asked Questions","wyvern-plugin")),i.map((function(e,t){return Object(a.createElement)("div",{id:"faq-"+t,className:"faq"},Object(a.createElement)("h3",{id:"faq-"+t+"-header",className:"faq-header accordion-header"},Object(a.createElement)("button",{className:"accordion-trigger"},Object(a.createElement)("span",{className:"faq-header-text"},e.title.rendered),Object(a.createElement)("span",{className:"fas fa-plus"}))),Object(a.createElement)("div",{id:"faq-"+t+"-content",class:"faq-content-container accordion-panel",role:"region"},Object(a.createElement)("div",{class:"faq-content accordion-content",dangerouslySetInnerHTML:{__html:e.content.rendered}})))}))))):Object(a.createElement)("p",{className:"results"},Object(a.createElement)(u.Spinner,null),Object(l.__)("Loading...","wyvern-plugin")):Object(a.createElement)("p",{className:"results"},Object(a.createElement)(u.Spinner,null),Object(l.__)("Loading...","wyvern-plugin"))})),save:function(e){return null}})}]);