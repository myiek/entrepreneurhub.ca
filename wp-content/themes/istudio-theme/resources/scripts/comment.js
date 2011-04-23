(function(){
function goReply(commentID,author){
var nauthor='@'+author+': ';
var authorcommt;
if(document.getElementById('comment')&&document.getElementById('comment').type=='textarea'){
authorcommt=document.getElementById('comment');
}else{return false;}
if(document.selection){
authorcommt.focus();
sel=document.selection.createRange();
sel.text=nauthor;
authorcommt.focus();
}else if(authorcommt.selectionStart||authorcommt.selectionStart=='0'){
var startPos=authorcommt.selectionStart;
var endPos=authorcommt.selectionEnd;
var cursorPos=endPos;
authorcommt.value=authorcommt.value.substring(0,startPos)+nauthor+authorcommt.value.substring(endPos,authorcommt.value.length);
cursorPos+=nauthor.length;
authorcommt.focus();
authorcommt.selectionStart=cursorPos;
authorcommt.selectionEnd=cursorPos;
}else{
authorcommt.value+=nauthor;
authorcommt.focus();
}}
window['istoJSCM']={};
window['istoJSCM']['goReply']=goReply;
})();