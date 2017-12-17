//Elmer Dea
//10/10/17
//various utilities



//checks if 'repeat password' input matches
//entirely for user convenience, not real validation
//10/16
function passMatch(input)
{ 	
	document.getElementById("warn").innerHTML= 'Passwords do not match';
	if (input.value!=document.getElementById('password').value)
		{
            document.getElementById('warn').innerHTML= 'Passwords do not match';
        } 
		else 
		{
            document.getElementById('warn').innerHTML="";
        }
}

//switch between login and register panels
//10/10
function regTog()
{
	var x=document.getElementById("login");
	var y=document.getElementById("register");
	x.classList.toggle("hide");
	y.classList.toggle("hide");
	
	var z=document.getElementById("reg").innerHTML;
	if (z=="Register Now"){		
		document.getElementById("reg").innerHTML = "Login With Existing Account";
	}
	else {
		document.getElementById("reg").innerHTML = "Register Now";
	}
}
function pickTog()
{
	var x=document.getElementById("voterPick");
	x.classList.toggle("hide");
}

//Hide/show 'logged in as'
//10/18
function account() 
{
	var x=document.getElementById("nameLog");
	if (document.getElementById("accName").innerHTML==="")
	{
		x.classList.add("hide");
	}
	else
	{
		x.classList.remove("hide");
	}
	
	//10/23
	//and the login panel if already logged in
	var logPan= document.getElementById("logPan");
	if (document.getElementById("loginFail").innerHTML=="active")
	{
		logPan.classList.add("hide");
	}
	else
	{
		logPan.classList.remove("hide");
	}
	
}
window.onload=account;

//10/24
//create new inputs when 'add option' is pressed
//identical to refOpt1, optDesc1, color1 but with incrementing names
var opts = 1;
//some default colors, first two are placeholders
var colors = ["#000066","#000066","#ff0000", "#003300", "#660066", "#00ffff", "#996600", "#999966"];
function newOpt(buttId)
{
	opts++;
	document.getElementById("optCount").value = opts;
	var opt = document.createElement("input");
		opt.type = "text";
		opt.className = "option";
		opt.setAttribute('placeholder',"Option");
		var optName = "refOpt"+opts.toString();
		opt.name = optName;
	
	var desc = document.createElement("textarea");
		desc.setAttribute('placeholder',"Description of Option");
		desc.setAttribute('rows',"3");
		desc.setAttribute('cols',"50");
		desc.setAttribute('name',"optDesc"+opts.toString());
	
	var color = document.createElement("input");
		color.type = "color";
		var colorNum = (opts<=colors.length)? opts : 0;
		color.setAttribute('value',colors[opts]);
		color.setAttribute('placeholder',colors[opts]);
		color.setAttribute('name',"color"+opts.toString());
		
	
	var target = document.getElementById("referendum");
	var create = document.getElementById("refBut");
	var butt= document.getElementById("buttId");
	
    target.insertBefore(opt, create);
	target.insertBefore(desc, create);
	target.insertBefore(color, create);
}   
//11/26
function showEditRef(ID)
{
	account();
	var outPut;
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
			//refInfo
			outPut = JSON.parse(this.responseText);
			var refInfo = outPut["refInfo"];
			var target = document.getElementById("display");
			var issue = "<div class='refTitle'>"+refInfo[0]+"</div>";		
			var org = "<div>"+refInfo[1]+"</div>";
			var deadline = refInfo[2]=="0000-00-00"?"<div>No Deadline</div>":"<div>Deadline:"+ refInfo[2] +"</div>";
			var desc =	"<div>"+refInfo[3]+"</div>";
			target.insertAdjacentHTML("beforeend", issue);
			target.insertAdjacentHTML("beforeend", org);
			target.insertAdjacentHTML("beforeend", deadline);
			target.insertAdjacentHTML("beforeend", desc);
			
			
			var target = document.getElementById("displayOpts");
			var opts = outPut["opts"];
			var optCount = Object.keys(opts).length;
			var optList;
			for (n=0; n<=optCount; n++)
			{
				//populate selections
				var rankName= n==0? "Abstain" : n.toString();
				optList+="<option value=\""+n.toString()+"\">"+rankName+"</option>";
			}
			for (i=0; i<optCount; i++)
			{
				//list option name and desc
				var option = opts[i];
				var optDiv = "<div class=\"title\">"+option["optName"]+"</div><div>"+option["description"]+"</div>";
				target.insertAdjacentHTML("beforeend", optDiv);
				
				//
				var formStart = "<form id=\"opt" + i.toString() + "\"action=\"updateOpt.php\" method=\"post\">";
				var optID = "<input id=\"optID\" name=\"optID\" type=\"hidden\" value=\"" + option["ID"] + "\">";
				var refID = "<input id=\"refID\" name=\"refID\" type=\"hidden\" value=\"" + ID + "\">";
				var updateOpt= "<input name = \"updateOpt\" placeholder=\"New Name\">"+"<input name = \"updateOptDesc\" placeholder=\"New Description\">"  + "<button id=\"optsBut\" type=\"submit\">Update</button>" + "</form>"
				target.insertAdjacentHTML("beforeend", formStart + optID + refID + updateOpt);
			}
			
			populateVoters();
			showEligibleVoters(ID);
		}
	}	
	xmlhttp.open("GET", "getref.php?ID=" + ID, true);
    xmlhttp.send();	
	

}

//10/26
//AJAX to display referendum information and voting options
function showRef(ID)
{
	account();
	var outPut;
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
			//refInfo
			outPut = JSON.parse(this.responseText);
			var refInfo = outPut["refInfo"];
			var target = document.getElementById("display");
			var issue = "<div class='refTitle'>"+refInfo[0]+"</div>";		
			var org = "<div>"+refInfo[1]+"</div>";
			var deadline = refInfo[2]=="0000-00-00"?"<div>No Deadline</div>":"<div>Deadline:"+refInfo[2]+"</div>";
			var desc =	"<div>"+refInfo[3]+"</div>";
			target.insertAdjacentHTML("beforeend", issue);
			target.insertAdjacentHTML("beforeend", org);
			target.insertAdjacentHTML("beforeend", deadline);
			target.insertAdjacentHTML("beforeend", desc);
			
			//opts
			var opts = outPut["opts"];
			var optCount = Object.keys(opts).length;
			var optList;
			for (n=0; n<=optCount; n++)
			{
				//populate selections
				var rankName= n==0? "Abstain" : n.toString();
				optList+="<option value=\""+n.toString()+"\">"+rankName+"</option>";
			}
			for (i=0; i<optCount; i++)
			{
				//list option name and desc
				var option = opts[i];
				var optDiv = "<div>"+option["optName"]+"<br>"+option["description"]+"</div>";
				target.insertAdjacentHTML("beforeend", optDiv);
				
				//list option ID as hidden input
				var optCountInput = "<input id=\"optID\" name=\"optID"+ i.toString() +"\" type=\"hidden\" value=\"" + option["ID"] + "\" form=\"vote\">";
				target.insertAdjacentHTML("beforeend", optCountInput);
				
				//select list of rankings equal to number of options; 0 for abstain
				var optRank = "Rank: <select name=\"optRank"+i.toString()+"\" form=\"vote\" onchange=\"disableOpt()\">"+optList+"</select>";
				target.insertAdjacentHTML("beforeend", optRank);
			}
			var voteForm = "<form onsubmit= \"resetOptions()\"action=\"countVote.php\" method=\"post\" id=\"vote\"><input type=\"submit\"></form>";
			var optCountInput = "<input id=\"optCount\" name=\"optCount\" type=\"hidden\" value=\"" + optCount + "\" form=\"vote\">";
			target.insertAdjacentHTML("beforeend", voteForm);
			target.insertAdjacentHTML("beforeend", optCountInput);
			
			//votes
			var votesByRank = skipRankGaps(outPut["votes"], optCount);

			var currentVote = "<div>Your current preference is: " + votesByRank.join(" > ");
			target.insertAdjacentHTML("beforeend", currentVote);
			
			//client-side check if currently logged in user is eligible for this ref
			var voters = outPut["voters"];
			var eligibility = 0;
			for (i=0;i<Object.keys(voters).length; i++)
			{
				if (voters[i]["username"] == outPut["user"])
				{
					eligibility = 1;
				}
			}
			if (eligibility ==0)
			{
				var ineligible = "<div>You are not currently eligible for this referendum.  Log in to an account that is eligible or contact its creator: " + 
					"<a href='profile.php?username=" + outPut["creator"]["username"] + "'>" + outPut["creator"]["username"] +"<div>";
				document.getElementById("alternate").insertAdjacentHTML("beforeend", ineligible);
				target.classList.add("hide");
			}
			
			//check if currently logged in user is the creator of this ref
			if (outPut["creator"]["username"] == outPut["user"])
			{
				var update = "<div>You are the creator of this referendum.  <a href='editRef.php?ID=" + ID + "'>Click here to edit it.</div>"
				document.getElementById("alternate").insertAdjacentHTML("beforeend", update);
			}
			
        }
    };
    xmlhttp.open("GET", "getref.php?ID=" + ID, true);
    xmlhttp.send();		
	
	tallyVotes(ID);
	//window.history.back();
}

//11/9
function skipRankGaps(votes, optCount)
{
	var votesByRank = [];
	//ensures that preferences are in sequential order even if some ranks are skipped
	for (n=0; n<optCount; n++)
	{
		if(votes[n].hasOwnProperty('choiceRank') && votes[n]["choiceRank"]!=0)
		{
			votesByRank.push(votes[n]["optName"]);
		}
	}
	return votesByRank;
}

//12/6
//gets current un-eliminated favorite option per eligible voter
function getRankOrders(ID, optNames, outPut)
{
	var users = [];
	var userVotes = [];		//mirrors list of users, current favorite vote
	for (var a in outPut["voters"])
	{
		if(outPut["voters"][a].hasOwnProperty('username'))
		{
			users.push(outPut["voters"][a]["username"]);
		}
	}
	var rank = Array(users.length).fill(Object.keys(outPut["opts"]).length);	//mirrors list of users, preference rank of current favorite vote
	for (var i=0;i<Object.keys(outPut["votes"]).length;i++)			//check each vote
	{
		for (var x=0; x<users.length;x++)							//for every voter
		{
			for (var y = 0; y<optNames.length; y++)					//if option hasn't been eliminated yet	
			{
				if (outPut["votes"][i]["optName"]==optNames[y])			//match option name with existing name
				{						
					if (users[x]==outPut["votes"][i]["voter"])			//for this voter
					{
						if (parseInt(outPut["votes"][i]["choiceRank"]) < rank[x])  //if is a more favorable ranking for this voter
						{
							rank[x] = parseInt(outPut["votes"][i]["choiceRank"]);  //becomes newest most favorable ranking
							userVotes[x] = outPut["votes"][i]["optName"];		//add favorite option to mirrored array 
						}
					}
				}
			}
		}
	}
	return userVotes;
}

//11/6
//Displays total (votes per option)column per (rank)table for a (referendum)page 
//autmatically skips gaps in vote ranks
function tallyVotes(ID)
{
	var outPut;
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
			outPut = JSON.parse(this.responseText);
			
			//opts for chart labeling
			
			var opts = outPut["opts"];	//list of options and associated data
			var votes = outPut["votes"];	//list of votes and assoc data
			
			var votesPerOption = [];
			var optNames = [];
			var optID = [];
			var colors = [];
			var round = 1; //First round of vote cascade (rank 1s)
			for (var n in opts)
			{
				
				optID.push(opts[n]["ID"]);				//ID for reference
				optNames.push(opts[n]["optName"]);		//optNames chart axis
				colors.push('#' + opts[n]["color"]);	//color for bars
				
				var voteCount = 0;
				for (var i in votes)					
				{
					if (votes.hasOwnProperty(i) && 			//for this option, every vote at ROUND rank
						votes[i]["optID"]== optID[n] && 
						votes[i]["choiceRank"]==round)
					{			
						voteCount+=1;						//count this per option
					}
				}
				votesPerOption[n]=voteCount;				//and record in this element of array; 
			}
			drawRef(round, optNames, colors, votesPerOption);
			
			function drawRef(round, optNames, colors, votesPerOption)
			{
				var currentFavorites = getRankOrders(ID,optNames,outPut);	//list of current remaining favorite option per voter
				var currentVotes = [];
				for (var i=0;i<optNames.length;i++)
				{
					var voteCount=0;
					for(var x=0;x<currentFavorites.length;x++)
					{
						if (optNames[i]==currentFavorites[x])
						{
							voteCount+=1;
						}
					}
					currentVotes[i]=voteCount;
				}
				//one data array per chart
				//actual vote data per opt
				var newCanvas = "<canvas id=\"chart" + round + "\"></canvas>";
				document.getElementById("charts").insertAdjacentHTML("beforeend", newCanvas);
				var ctx = document.getElementById('chart' + round).getContext('2d');
				var chart = new Chart(ctx, {
					// The type of chart we want to create
					type: 'horizontalBar',
					// The data for our dataset
					data: {
						labels: optNames,
						datasets: [{
							label: "Round " + round,
							backgroundColor: colors,
							borderColor: 'black',
							data: currentVotes,
						}]
					},
					options: {
						scales: {
							xAxes: [{
								ticks: {
									beginAtZero:true
								}
							}]
						}
					}
				});	
				var low=votesPerOption[0];			//allows removal of multiple lowest values
				var lowPos=[];
				for (var i =0;i<votesPerOption.length;i++)
				{
					if (low==votesPerOption[i])
					{
						lowPos.push(i);
					}
					if (votesPerOption[i]<low)
					{
						low = votesPerOption[i];
						lowPos=[i];
					}
				}
				for (var i = lowPos.length-1; i >=0; i-=1)
				{
					votesPerOption.splice(lowPos[i],1);
					optNames.splice(lowPos[i],1);
					colors.splice(lowPos[i],1);
				}
//votesPerOption.splice(lowestPos,1);
//optNames.splice(lowestPos,1);
//colors.splice(lowestPos,1);			
				if (optNames.length==1)
				{
					var winner = "<span>"+optNames[0]+"</span>";
					document.getElementById("winner").insertAdjacentHTML("beforeend", winner);
				}
				if (optNames.length > 0)
				{
					drawRef(round+1,optNames,colors,votesPerOption);
				}
			}
		}
	};
	xmlhttp.open("GET", "getVotes.php?ID=" + ID, true);
    xmlhttp.send();
}
//11/3
function resetOptions()
{
	var optCount = document.getElementById("optCount").value;
	var selects = document.getElementsByTagName('select');
	//reset all disables
	for (i = 0; i<selects.length;i++)
	{
		//4 options and 1 default makes 5
		for (n = 0; n<=selects.length;n++)
		{
			selects[i].options[n].disabled=false;
		}
	}
}

//11/1
//stop duplicate rank options client-side
function disableOpt()
{
	var optCount = document.getElementById("optCount").value;
	var selects = document.getElementsByTagName('select');
	resetOptions();
	//apply disables
	for (i = 0; i<selects.length;i++)
	{
		var input = selects[i].selectedIndex;
		if (input!==0)
		{
			for (n = 0; n<selects.length;n++)
			{
				selects[n].options[input].disabled=true;
			}
		}
	}	
}

//11/12

function findUsers(str, mode) {
  if (str.length==0 && mode==1) { 
    document.getElementById("users").innerHTML="";
    document.getElementById("users").style.border="0px";
    return;
  }
  if (str.length==0 && mode==2) { 
    document.getElementById("newRefOptions").innerHTML="";
    document.getElementById("newRefOptions").style.border="0px";
    return;
  }
  xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) 
	{
		//for user search page
		var users = JSON.parse(this.responseText);
		var target = document.getElementById("users");
		var list = "";
		if (mode==1){
			for (var x = 0; x < users.length; x++){
				var result = "<a href='profile.php?username=" + users[x]["username"] + "'>" + users[x]["username"] + "<br>";
				list+=result;
			}	
		}
		target.innerHTML = list;
		//for new referendum page, add eligible voters
		/*
		if (mode==2){
			for (var x = 0; x < users.length; x++){
				var result = "<br><button class=\"addOpt\" type=\"button\" onclick=\"addVoter(this.innerHTML,this.name)\" name=\"voter" + x + "\">" + users[x]["username"];
				document.getElementById("newRefOptions").insertAdjacentHTML("beforeend", result);
			}
		}*/
    }
  }
  xmlhttp.open("GET","getUsers.php?name="+str,true);
  xmlhttp.send();
}
/*
function addVoter(voter)
{
	var result = "<input type=\"search\" readonly=\"readonly\" name=\"voter\"" + "value=\""  + voter + "\">";
	document.getElementById("newRefUsers").insertAdjacentHTML("beforeend", result);
}*/

//11/12
//display content info for a given name
function showProfile(username)
{
	account();
	var outPut;
	var target = document.getElementById("profile");
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{

			outPut = JSON.parse(this.responseText)["profile"];
			var name = "<div class=\"title\">"+ outPut["username"] +"'s Profile" + "</div>";
			var info = "<div>Name: " + outPut["fullname"] + 
				"<br>Email: " + outPut["email"] +
				"<br>Phone: " + outPut["phone"] + "</div>";
			target.insertAdjacentHTML("beforeend", name);
			target.insertAdjacentHTML("beforeend", info);
			
			if (JSON.parse(this.responseText)["self"]==1)
			{
				//created refs
				var refs = JSON.parse(this.responseText)["creatorOf"];
				var myRefs = "<br><div>Active referenda that you have created:<br>";
				for (var x in refs)
				{
					if (refs.hasOwnProperty(x))
					{
						myRefs+= "<a href=ballot.php?ID=" + refs[x]["refID"] + ">" + refs[x]["issue"] + "</a><br>";
					}
				}
				myRefs+="</div>";
				
				//participating refs
				var refsV = JSON.parse(this.responseText)["voterIn"];
				var myRefsV = "<br><div>Active referenda that you are eligible to vote in:<br>";
				for (var x in refsV)
				{
					if (refsV.hasOwnProperty(x))
					{
						myRefsV+= "<a href=ballot.php?ID=" + refsV[x]["refID"] + ">" + refsV[x]["issue"] + "</a><br>";
					}
				}
				myRefsV+="</div>";
				var edit = "<br><form action=\"updateProfile.php\" method= \"post\"> Edit My Profile<br>New Name: <input name =\"newName\"><br>New Email <input name =\"newEmail\"><br>New Phone <input name = \"newPhone\"><button type=\"submit\">Update</button></form>";
				var deleteProfile = "<br><br><br>Note: All referenda that you are the creator of must be expired or deleted before account deletion is allowed<form action=\"deleteProfile.php\" method=\"post\"><button type=\"submit\">DELETE MY ACCOUNT</button></form>";
				target.insertAdjacentHTML("beforeend", myRefs);
				target.insertAdjacentHTML("beforeend", myRefsV);
				target.insertAdjacentHTML("beforeend", edit);
				target.insertAdjacentHTML("beforeend", deleteProfile);
			}
		}
	};
	
	var url = "getProfile.php?username=" + username;
	xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

//11/12
//generate list for voter selection
function populateVoters()
{
	account();
	var outPut;
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
			outPut = JSON.parse(this.responseText);
			for (var i=0;i<outPut.length;i++)
			{
				var opt = "<option value = "+outPut[i]["username"]+"> "+outPut[i]["username"]+" </option>";
				document.getElementById("voters").insertAdjacentHTML("beforeend", opt);
			}
		}
	};
	xmlhttp.open("GET", "getAllUsers.php", true);
    xmlhttp.send();
}

//11/26/17
//list voters currently eligible for this referendum
function showEligibleVoters(ID)
{
	var outPut;
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
        if (this.readyState == 4 && this.status == 200) 
		{
			outPut = JSON.parse(this.responseText);
			for (var i=0;i<outPut.length;i++)
			{
				var name = outPut[i]["username"];
				if (outPut[i]["creator"] == 1)
				{
					name += "(Creator)";
				}
				var eVoter = "<li>" + name + "</li>";
				document.getElementById("eligible").insertAdjacentHTML("beforeend", eVoter);
			}
		}
	};
	xmlhttp.open("GET", "getEligible.php?ID="+ID, true);
    xmlhttp.send();
}




