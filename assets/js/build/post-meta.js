!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=6)}([function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){!function(){e.exports=this.wp.i18n}()},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t){!function(){e.exports=this.wp.data}()},function(e,t){!function(){e.exports=this.wp.editPost}()},function(e,t){!function(){e.exports=this.wp.plugins}()},function(e,t,n){"use strict";n.r(t);var r=n(0),o=n(1),i=n(4),u=n(5),a=n(2),c=n(3),l=function(e){var t=e.featurePost,n=e.featuredVideo;return Object(r.createElement)(r.Fragment,null,Object(r.createElement)(a.PanelBody,{title:Object(o.__)("Featured the Post?","wyvern-plugin"),initialOpen:!0},Object(r.createElement)(a.ToggleControl,{label:Object(o.__)("Feature the post?","wyvern-plugin"),help:t?Object(o.__)("The post will be featured.","wyvern-plugin"):Object(o.__)("The post will NOT be featured.","wyvern-plugin"),checked:t,onChange:function(t){return e.updateFeaturePost(t)}})),Object(r.createElement)(a.PanelBody,{title:Object(o.__)("Featured Video","wyvern-plugin"),initialOpen:!0},Object(r.createElement)(a.TextControl,{label:"Featured Video URL",value:n,onChange:function(t){return e.updateFeaturedVideo(t)}})))};l=Object(c.withSelect)((function(e){return{featurePost:e("core/editor").getEditedPostAttribute("meta").feature_post,featuredVideo:e("core/editor").getEditedPostAttribute("meta").featured_video}}))(l),l=Object(c.withDispatch)((function(e){return{updateFeaturePost:function(t){e("core/editor").editPost({meta:{feature_post:t}})},updateFeaturedVideo:function(t){e("core/editor").editPost({meta:{featured_video:t}})}}}))(l),Object(u.registerPlugin)("wyvern-plugin-post-meta",{render:function(){return Object(r.createElement)(i.PluginDocumentSettingPanel,{name:"fx-group-post-meta-panel",title:Object(o.__)("Additional Post Information","wyvern-plugin"),className:"wyvern-plugin-post-meta"},Object(r.createElement)(l,null))}})}]);