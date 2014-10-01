var bookname="";
//globar array values for the navigation system
indexOfAudio=0;
audio=[];
chapters=[];
pages=[];
paragraphs=[]
sentences=[];
sentenceTimeStamps=[];
globalTime=0;
v=document.getElementById('video'); 
function _(element)
{
	return document.getElementById(element);
}
$(function(){
   hideall();
});
$(function() 
{
	$( "#accordion" ).accordion();//library
	$( "#accordion1" ).accordion();//mybooks
});
$(function() 
{
    $( "#slider" ).slider({max:20},{orientation:"vertical"},{min:1},{ranger:true},{step:1},{value:10});	
  });
$(function(){
	$("#slider").slider({change:function(event, ui){
	document.getElementById("video").playbackRate=(($('#slider').slider("option", "value"))/10);
	}});
});
function readNavigation(bookname,file)//this function reads the navigation file and sends the info to trigger function
{
	var xmlhttp;
	var info;
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{	
			info=xmlhttp.responseText;
			trigger(bookname,info);
		}
	}
	xmlhttp.open("GET",bookname+"/"+file,true);
	xmlhttp.send();
}
function all_sequential_audio_files(bookname)//this is the main function. as soon as the book is clicked on the home page, this function is called
{
	window.bookname="Books/"+bookname;
	bookname=window.bookname;
	readNavigation(bookname,"navigation.dlf");
}
function trigger(bookname,info)//called by readNavigation function. This function calls playVIdeo with the parameters information array and bookname
{
	allFiles=info.split("$");
	playVideo(allFiles,bookname);
}
function playVideo(allArrays,bookname) //called by trigger function. 
{
	window.indexOfAudio=0;//all the arrays are created with the allArrays array
	for(i=0;i<allArrays.length;i=i+5)
	{
		window.chapters.push(allArrays[i]);
		window.pages.push(allArrays[i+1]);
		window.paragraphs.push(allArrays[i+2]);
		window.sentences.push(allArrays[i+3]);	
		window.sentenceTimeStamps.push(allArrays[i+4]);
	}
	//audio array has the unique speechgen names which is used in the audio flow
	for(i=0;i<window.sentences.length;i++)
	{
		if(window.audio.indexOf(window.bookname+"/"+window.sentences[i])==-1)
		{
			window.audio.push(window.bookname+"/"+window.sentences[i]);
		}
	}
	v=document.getElementById('video');
	v.src=window.audio[window.indexOfAudio];
	v.play();
	v.focus();
	v.addEventListener('loadeddata', function(){v.currentTime = window.globalTime;window.globalTime=0;}, true);
	//used for the audio flow. as soon as one mp3 file is ended, the next one begins
	v.addEventListener('ended',function(e){v.pause();window.indexOfAudio++;v.src=window.audio[window.indexOfAudio];v.play();return false;},true);
}

function sentence(direction)//used for sentence navigation. If direction=1, then it is next else it is previous
{
	createLog("using sentence navigation with direction = "+direction);//creates the log
	currentSrc=v.src.split("/").pop();
	timeNow=v.currentTime;
	startIndex=window.sentences.indexOf(currentSrc);
	lastIndex=window.sentences.lastIndexOf(currentSrc);
	timeArray=window.sentenceTimeStamps.slice(startIndex,lastIndex+1);
	//timeArray is all the timestamps for a particular audio speechgen
	f=0;
	b=0;
	//this block is used to find the nearest timestamp
	if(direction==1)
	{
		for(i=0;i<timeArray.length;i++)
		{			
			if(timeNow<timeArray[i])
			{				
				f++;
				goToLocation(window.bookname,window.sentences[startIndex+i],window.sentenceTimeStamps[startIndex+i]);				
				break;
				return 0;
			}
		}
		if(f==0)
		{			
			goToLocation(window.bookname,window.sentences[lastIndex+1],window.sentenceTimeStamps[lastIndex+1]);
			return 0;
		}
	}	
//same as above
	else if(direction==-1)
	{
		for(i=0;i<timeArray.length;i++)
		{
			if(timeNow>timeArray[timeArray.length-i-1])
			{
				b++;
				goToLocation(window.bookname,window.sentences[lastIndex-i-1],window.sentenceTimeStamps[lastIndex-i-1]);		
				break;
				return 0;
			}
		}
		if(b==0)
		{
			goToLocation(window.bookname,window.sentences[startIndex-1],window.sentenceTimeStamps[startIndex-1]);			
			return 0;
		}	
	}
	return 0;
}

function navRest(direction,nav)//all the other navigations(paragraph, page, chapter) uses this function
{
	currentSrc=v.src.split("/").pop();
	timeNow=v.currentTime;
	startIndex=window.sentences.indexOf(currentSrc);
	lastIndex=window.sentences.lastIndexOf(currentSrc);
	timeArray=window.sentenceTimeStamps.slice(startIndex,lastIndex+1);
	//timeArray is same as explained above
	f=0;
	g=0;
	//same as above
	if(direction==1)
	{
		for(i=0;i<timeArray.length;i++)
		{			
			if(timeNow<timeArray[i])
			{
				f++;				
				currentIndex=startIndex+i;
				break;
				
			}
		}
		if(f==0)
		{
			currentIndex=lastIndex+1;	
		}
	}	
	else if(direction==-1)
	{		
		for(i=0;i<timeArray.length;i++)
		{
		
			if(timeNow>timeArray[timeArray.length-i-1])
			{
				g++;
				currentIndex=lastIndex-i-1;				
				break;
				
			}
		}
		if(g==0)
		{
			currentIndex=startIndex-1;			
		}	
	}
	//nav is 0 for paragraph
	//gets the newParagraph information based on the currentParagraph and direction value
	if(nav=="0")
	{
		currentParagraph=window.paragraphs[currentIndex];
		if(direction==1)
		{
			newParagraph=String(Number(currentParagraph)+1);
		}
		else if(direction==-1)
		{
			newParagraph=String(Number(currentParagraph));
		}
		index=window.paragraphs.indexOf(newParagraph);
	}
	//same as above
	else if(nav=="1")
	{
		currentPage=window.pages[currentIndex];
		if(direction==1)
		{
			newPage=String(Number(currentPage)+1);
		}
		else if(direction==-1)
		{
			newPage=String(Number(currentPage)-1);
		}		
		index=window.pages.indexOf(newPage);
	}
	//same as above
	else if(nav=="2")
	{
		currentChapter=window.chapters[currentIndex];
		if(direction==1)
		{
			newChapter=String(Number(currentChapter)+1);
		}
		else if(direction==-1)
		{
			newChapter=String(Number(currentChapter));
		}
		index=window.chapters.indexOf(newChapter);
	}
	createLog("using "+nav+" navigation with direction = "+direction);
	goToLocation(window.bookname,window.sentences[index],window.sentenceTimeStamps[index]);
	return 0;
}
function goToLocation(bookname,audioFileName,time)//goTOLocation is called by bookmarks, navigation scripts. Takes bookname, audioFIlename and time as arguments
{
	audioFile=window.audio.indexOf(window.bookname+"/"+audioFileName);
	window.indexOfAudio=audioFile;	
	window.globalTime=time;
	v.src=window.audio[window.indexOfAudio];
	hideall();
	return 0;
}

function doc_keyUp(e) //keyboard shortcuts
{	
	v=document.getElementById('video'); 
	createLog("Key press "+e.keyCode);
	//alert(e.keyCode);
	if(document.activeElement.id!="bookvalue" && document.activeElement.id!="feedvalue")

	{	
		if (e.keyCode==187) 
		{//+
			v.volume=v.volume+0.1;					
		}
		else if (e.keyCode==189) 
		{     //down arrow   
			v.volume=v.volume-0.1;		
		}
		else if(e.keyCode==39 && e.ctrlKey)//"ctrl+right" 
		{
			navRest(1,0);
		}
		else if(e.keyCode==37 && e.ctrlKey)//"ctrl+left" key
		{
			navRest(-1,0);
		}
		else if (e.keyCode==39) 
		{        //right arrow
			sentence(1);
		}	
		else if (e.keyCode==37) 
		{        //left arrow		
			sentence(-1);
		}
		else if(e.keyCode==38 && e.ctrlKey)//"up+ctrl" key
		{
			navRest(-1,2);
		}
		else if(e.keyCode==40 && e.ctrlKey)//"down +ctrl" key
		{
			navRest(1,2);
		}
		else if(e.keyCode==38)//"up" key
		{
			navRest(-1,1);
		}
		else if(e.keyCode==40)//"down" key
		{
			navRest(1,1);
		}		
		else if (e.keyCode==83)//s  
		{        
			v.pause();
			v.currentTime=0;
		}
		else if(e.keyCode==32)//space bar
		{
			if(v.paused)
			{
				v.play();
			}
			else
			{
				v.pause();
			}
		}
		else if (e.altKey && e.keyCode == 76) //alt+L
		{
			window.location='logout.php';
		}
		else if (e.altKey && e.keyCode == 65) //alt+A
		{
			addToMyBooks();
		}
		else if(e.keyCode==65)//A
		{
			$("#focusable").focus();		
		}
		else if(e.keyCode==190)//> key
		{
			v.playbackRate+=0.1;
			$("#slider").slider('value',($('#slider').slider("option", "value"))+1);		
		}
		else if(e.keyCode==188)//< key
		{
			v.playbackRate-=0.1;
			$("#slider").slider('value',($('#slider').slider("option", "value"))-1);	
		}
		else if(e.keyCode==48)
		{
			v.playbackRate=1.0;
			$("#slider").slider('value',10);	
		}
		else if(e.keyCode==81)
		{
			window.location="search.php";
		}
	}
}
document.addEventListener('keyup', doc_keyUp, false);
document.getElementById("bookmarkimg").addEventListener('click', function(){showBookmark();}, true);
