let direction = 4;
let imageUrl = "https://habbo.fr/habbo-imaging/avatarimage?figure=";
let setCode = document.querySelector('.avatarimage input[type=hidden]');
            
function openNav(point) {
    var mainNavigationObjects = document.getElementsByClassName('mainNav');   
    for(var key in mainNavigationObjects) {
        var cObject = mainNavigationObjects[key];
        if(typeof cObject.classList == 'object') {
            if(cObject.getAttribute('nav-point') == point) {
                cObject.classList.add('selected');
                openSubnav(point);
            } else {
                cObject.classList.remove('selected');   
            }
        }
    }
    return false;
}
    
function openSubnav(point) {
    var subNavigationObjects = document.getElementsByClassName('sub');   
    for(var key in subNavigationObjects) {
        var cObject = subNavigationObjects[key];
        if(typeof cObject == 'object') {
            if(cObject.getAttribute('subnav') == point) {
                cObject.classList.add('selected');
            } else {
                cObject.classList.remove('selected');
            }
        }
    }
    return false;
}
    
function activateSub(point) {
    var subNavigationObjects = document.getElementsByClassName('nav');   
    for(var key in subNavigationObjects) {
        var cObject = subNavigationObjects[key];
        if(typeof cObject == 'object') {
            if(cObject.getAttribute('subnav-point') == point) {
                cObject.classList.add('selected');
            } else {
                cObject.classList.remove('selected');
            }
        }
    }
    return false;
}
    
function setGender(gender) {
    Avatargenerator.setGender(gender);
    setSet(Avatargenerator.currentSet);
    drawAvatar();
}
    
setSet(Avatargenerator.currentSet);
drawAvatar(setCode);
    
// function getCode() {
//     console.log(Avatargenerator.generateCode());   
// }

function inArray(value, array) {
    return array.indexOf(value) > -1;
}
    
function setClothes() {
    var uSet = Avatargenerator.getSet('U', Avatargenerator.currentSet);
    var gSet = Avatargenerator.getSet(Avatargenerator.gender, Avatargenerator.currentSet);
    var set = uSet.concat(gSet);
    var loadedClothes = [];
                
    set.forEach(function(element, index, array) {
        if(!inArray(element, loadedClothes)) {
            loadedClothes.push(element);
            div = document.createElement('div');
            if(Avatargenerator.getByType(Avatargenerator.currentSet)[1] == element) {
                div.className = 'clothes-object '+Avatargenerator.currentSet+' '+element+' selected'; 
            } else {
                div.className = 'clothes-object '+Avatargenerator.currentSet + ' '+element;
            }
            div.setAttribute('remove', 0);
            div.setAttribute('element', element);
            color = 0;
            if(Avatargenerator.getColor(Avatargenerator.currentSet) != null) {
                color = Avatargenerator.getColor(Avatargenerator.currentSet);    
            } 

            div.style.backgroundImage = "url('" +imageUrl+Avatargenerator.currentSet+"-"+element+"-"+color+"')";

            div.onclick = function() {   
                var clothesObjects = document.getElementsByClassName('clothes-object');
                for(var key in clothesObjects) {
                    var currentObject = clothesObjects[key];
                    if(typeof currentObject.className == 'string') {                            
                        if(currentObject.classList[2] == element) {
                            if(typeof currentObject.classList[3] == 'undefined' && currentObject.classList[3] != 'selected') {
                                currentObject.classList.add('selected');   
                            }
                        } else {
                            currentObject.classList.remove('selected');   
                        }
                    }
                }
                Avatargenerator.setCloth(element,Avatargenerator.currentSet);
                return drawAvatar();
            };    
            document.getElementById('clothes').appendChild(div);
        }
    });
}

function setPalette() {
    var palette = [];
    
    Avatargenerator.getSets().forEach(function(e, i, a) {
        if(e[0] == Avatargenerator.currentSet) {
            palette = Avatargenerator.getPaletteById(e[1]);
        }  
    });
    palette.forEach(function(e, i, a) {
        if(typeof e != 'number') {
            var div = document.createElement('div');
            if(Avatargenerator.getColor(Avatargenerator.currentSet) == e[0]) {
               div.className = 'palette-child selected';
            } else {
                div.className = 'palette-child';
            }
            div.nColor = e[0];
            div.nType = Avatargenerator.currentSet;
            div.style.backgroundColor = '#'+e[1];
            div.onclick = function() {
                
                Avatargenerator.setColor(e[0], Avatargenerator.currentSet);
                                        
                var paletteObjects = document.getElementsByClassName('palette-child');
                for(var key in paletteObjects) {
                    var currentObject = paletteObjects[key];
                    if(typeof currentObject.className == 'string') {    
                        if(currentObject.nColor == e[0]) {
                            if(currentObject.nType == Avatargenerator.currentSet) {
                                currentObject.classList.add('selected');   
                            } else {
                                currentObject.classList.remove('selected');   
                            }
                        } else {
                            currentObject.classList.remove('selected');   
                        }
                    }
                }
                var clothesObjects = document.getElementsByClassName('clothes-object');
                for (var nKey in clothesObjects) {
                    var nCObject = clothesObjects[nKey];
                    
                    if(typeof nCObject.style != 'undefined') {
                        if(typeof nCObject.getAttribute('remove') == 'string' && nCObject.getAttribute('remove') == '0') {
                            nCObject.style.backgroundImage = "url('" +imageUrl+Avatargenerator.currentSet+"-"+nCObject.getAttribute('element')+"-"+e[0]+"')";
                        }
                    }
                }
                return drawAvatar();
            };
            document.getElementById("palette").appendChild(div);
        }
    });
}
    
function drawAvatar(oldLook = null) {
    let setAvatar = document.getElementById("avatar");

    if (oldLook) {
        setAvatar.style.backgroundImage = "url('" +imageUrl+oldLook.value+"&size=l&direction="+direction+"')";
    } else {
        setAvatar.style.backgroundImage = "url('" +imageUrl+Avatargenerator.generateCode()+"&size=l&direction="+direction+"')";
    }
    setCode.value = Avatargenerator.generateCode();
}
    
function rotateAvatar(ndirection) {
    if(ndirection == 'left') {
        if(direction == 7) {
            direction = 0;   
        } else {
            direction++;
        }
    } else {
        if(direction == 0) {
            direction = 7;   
        } else {
            direction--;
        }
    }
    return drawAvatar();
}
                
function setSet(set) {
    Avatargenerator.currentSet = set;
    document.getElementById("palette").textContent = '';
    document.getElementById("clothes").textContent = '';
    
    if(Avatargenerator.isAllowedToRemove(set)) {
   
        var div = document.createElement('div');
        div.className = 'clothes-object remove'; 
        div.setAttribute('remove', '1');
        div.onclick = function() {
            Avatargenerator.setCloth(0,Avatargenerator.currentSet);
            var clothesObjects = document.getElementsByClassName('clothes-object');
            for(var key in clothesObjects) {
                var currentObject = clothesObjects[key];
                if(typeof currentObject.className == 'string') {                            
                    currentObject.classList.remove('selected');   
                }
            }
            div.className = 'clothes-object remove selected'; 
            return drawAvatar();
        };
        document.getElementById("clothes").appendChild(div);
    }
    setClothes();
    setPalette();
}