
let CSID = document.getElementById('CSID');
let NameExtension = document.getElementById('NameExtension');
let DateOfBirth = document.getElementById('DateOfBirth');
let PlaceOfBirth = document.getElementById('PlaceOfBirth');
let Height = document.getElementById('Height');
let Weight = document.getElementById('Weight');
let BloodType = document.getElementById('BloodType');
let GSIS = document.getElementById('GSIS');
let PagIBIG = document.getElementById('PagIBIG');
let PHILHEALTH = document.getElementById('PHILHEALTH');
let SSS = document.getElementById('SSS');
let TIN = document.getElementById('TIN');
let AgencyNo = document.getElementById('AgencyNo');
let DualCountry =  document.getElementById('DualCountry');
let ResHouse_Block_LotNo = document.getElementById('ResHouse_Block_LotNo');
let ResStreet = document.getElementById('ResStreet');
let ResSubdivision_Village = document.getElementById('ResSubdivision_Village');
let ResBarangay = document.getElementById('ResBarangay');
let ResCity_Municipality = document.getElementById('ResCity_Municipality');
let ResProvince = document.getElementById('ResProvince');
let ResZipCode = document.getElementById('ResZipCode');
let PerHouse_Block_LotNo = document.getElementById('PerHouse_Block_LotNo');
let PerStreet = document.getElementById('PerStreet');
let PerSubdivision_Village = document.getElementById('PerSubdivision_Village');
let PerBarangay = document.getElementById('PerBarangay');
let PerCity_Municipality = document.getElementById('PerCity_Municipality');
let PerProvince = document.getElementById('PerProvince');
let PerZipCode = document.getElementById('PerZipCode');
let TelephoneNumber = document.getElementById('TelephoneNumber');
let MobileNumber = document.getElementById('MobileNumber');
let EmailAdd = document.getElementById('EmailAdd');
let Spouse_Surname = document.getElementById('Spouse_Surname');
let Spouse_Fistname = document.getElementById('Spouse_Firstname');
let Spouse_NameExtension = document.getElementById('Spouse_NameExtension');
let Spouse_Middlename = document.getElementById('Spouse_Middlename');
let Spouse_Occupation = document.getElementById('Spouse_Occupation');
let Spouse_Employer_Businessname = document.getElementById('Spouse_Employer_Businessname');
let Spouse_BusinessAddress = document.getElementById('Spouse_BusinessAddress');
let Spouse_TelephoneNumber = document.getElementById('Spouse_TelephoneNumber');

let Spouse_Children = [];

let NOF_Elementary = document.getElementById('Spouse_TelephoneNumber');
let NOF_Secondary = document.getElementById('Spouse_TelephoneNumber');
let NOF_Vocational = document.getElementById('Spouse_TelephoneNumber');
let NOF_College = document.getElementById('Spouse_TelephoneNumber');
let NOF_Graduate = document.getElementById('Spouse_TelephoneNumber');
let BE_D_C_Elementary = document.getElementById('Spouse_TelephoneNumber');
let BE_D_C_Secondary = document.getElementById('Spouse_TelephoneNumber');
let BE_D_C_Vocational = document.getElementById('Spouse_TelephoneNumber');
let BE_D_C_College = document.getElementById('Spouse_TelephoneNumber'); 
let BE_D_C_Graduate = document.getElementById('Spouse_TelephoneNumber');
let POA_From_Elementary = document.getElementById('Spouse_TelephoneNumber');
let POA_To_Elementary = document.getElementById('Spouse_TelephoneNumber');
let POA_From_Secondary = document.getElementById('Spouse_TelephoneNumber');
let POA_To_Secondary = document.getElementById('Spouse_TelephoneNumber');
let POA_From_Vocational = document.getElementById('Spouse_TelephoneNumber');
let POA_To_Vocational = document.getElementById('Spouse_TelephoneNumber');
let POA_From_College = document.getElementById('Spouse_TelephoneNumber');
let POA_To_College = document.getElementById('Spouse_TelephoneNumber');
let POA_From_Graduate = document.getElementById('Spouse_TelephoneNumber');
let POA_To_Graduate = document.getElementById('Spouse_TelephoneNumber');
let HL_UE_Elementary = document.getElementById('Spouse_TelephoneNumber');
let HL_UE_Secondary = document.getElementById('Spouse_TelephoneNumber');
let HL_UE_Vocational = document.getElementById('Spouse_TelephoneNumber');
let HL_UE_College = document.getElementById('Spouse_TelephoneNumber');
let HL_UE_Graduate = document.getElementById('Spouse_TelephoneNumber');
let YR_G_Elementary = document.getElementById('Spouse_TelephoneNumber');
let YR_G_Secondary = document.getElementById('Spouse_TelephoneNumber');
let YR_G_Vocational = document.getElementById('Spouse_TelephoneNumber');
let YR_G_College = document.getElementById('Spouse_TelephoneNumber');
let YR_G_Graduate = document.getElementById('Spouse_TelephoneNumber');
let Scho_AHR_Elementary = document.getElementById('Spouse_TelephoneNumber');
let Scho_AHR_Secondary = document.getElementById('Spouse_TelephoneNumber'); 
let Scho_AHR_Vocational = document.getElementById('Spouse_TelephoneNumber');
let Scho_AHR_College = document.getElementById('Spouse_TelephoneNumber');
let Scho_AHR_Graduate = document.getElementById('Spouse_TelephoneNumber');

let CivilService = [];

let WorkExperience = [];

let VoluntaryWork = [];

let LAD = [];


let FDDetails = document.getElementById('FDDetails');
let AODetails = document.getElementById('AODetails');
let CCDate = document.getElementById('CCDate');
let CCSOC = document.getElementById('CCSOC');
let CoVDetails = document.getElementById('CoVDetails');
let SFTSDetails = document.getElementById('SFTSDetails');
let CNOLEDetails = document.getElementById('CNOLEDetails');
let RGSDetails = document.getElementById('RGSDetails');
let SIoPSDetails = document.getElementById('SIoPSDetails');
let IGDetails = document.getElementById('IGDetails');
let PwDDetails = document.getElementById('PwDDetails');
let SPDetails = document.getElementById('SPDetails');

let References = [];

let C4_Picture = document.getElementById('C4_Picture');
let GIID = document.getElementById('GIID');
let ID_L_PNO = document.getElementById('ID_L_PNO');
let D_Pol = document.getElementById('D_PoI');

let info = document.getElementById('info');

let Submit = document.getElementById("Submit");



let Spouse_Add_Children = document.getElementById('Spouse-Add-Children');
Spouse_Add_Children.addEventListener('click', () => {
    // Textboxes
    let Children_Fullname = document.getElementById("Children_Fullname");
    let Children_Birthdate = document.getElementById("Children_Birthdate");


    let newChildDetail = 	{
		"ChildFullName" : Children_Fullname.value,
		"DateOfBirth" : Children_Birthdate.value
	};

    Spouse_Children.push(newChildDetail);

    // Container
    let spouse_children = document.getElementById('spouse-children');
    
    // New Element
    let children = document.createElement('tr');
    let td1 = document.createElement('td');
    let td2 = document.createElement('td');
    let td3 = document.createElement('td');


    td1.innerText = `${Children_Fullname.value}`;
    td2.innerText = `${Children_Birthdate.value}`;

    children.setAttribute("data-type-name", Children_Fullname.value);
    
    let button = document.createElement('button');
    button.innerHTML = "Remove";
    button.setAttribute("class", "btn btn-dark");
    button.addEventListener("click", () => {
        children.remove();
        button.remove();

        alert(children.getAttribute("data-type-name"));
        
        for(let i = 0; i < Spouse_Children.length; i++) {
            if(Spouse_Children[i]["ChildFullName"] == children.getAttribute("data-type-name")) {
                Spouse_Children.splice(i, 1);
                alert(JSON.stringify(Spouse_Children));
            }
        }
    });

    children.appendChild(td1);
    children.appendChild(td2);
    td3.appendChild(button);
    children.appendChild(td3);
    spouse_children.appendChild(children);
    
});




let CivilServiceAdd = document.getElementById('CivilServiceAdd');
CivilServiceAdd.addEventListener('click', () => {
    // All textboxes
    let CS_RA_CES_CSEE_DL = document.getElementById('CS_RA_CES_CSEE_DL');
    let Rating = document.getElementById('Rating');
    let DOT_C = document.getElementById('DOT_C');
    let POE_C = document.getElementById('POE_C');
    let LNumber = document.getElementById('LNumber');
    let LValidity = document.getElementById('LValidity');


    // New Object tobe inserted
    let newDetail = {
        'CS_RA_CES_CSEE_DL' : CS_RA_CES_CSEE_DL.value,
        'Rating' : Rating.value,
        'DOT_C' : DOT_C.value,
        'POE_C' : POE_C.value,
        'LNumber' : LNumber.value,
        'LValidity' : LValidity.value
    };

    // Inserted object
    CivilService.push(newDetail);


    // Container
    let civil_service = document.getElementById('civil-service');

    // New element tobe inserted
    let new_civil_service = document.createElement('tr');
    let td1 = document.createElement('td');
    let td2 = document.createElement('td');
    let td3 = document.createElement('td');
    let td4 = document.createElement('td');
    let td5 = document.createElement('td');
    let td6 = document.createElement('td');
    let td7 = document.createElement('td');


    new_civil_service.setAttribute("data-type-service", CS_RA_CES_CSEE_DL.value);
    td1.innerText = `${CS_RA_CES_CSEE_DL.value}`;
    td2.innerText = `${Rating.value}`;
    td3.innerText = `${DOT_C.value}`;
    td4.innerText = `${POE_C.value}`;
    td5.innerText = `${LNumber.value}`;
    td6.innerText = `${LValidity.value}`;


    // New element tobe inserted
    let button = document.createElement('button');
    button.innerHTML = "Remove";
    button.setAttribute("class", "btn btn-dark");
    button.setAttribute("type", "button");
    button.addEventListener("click", () => {
        new_civil_service.remove();
        button.remove();

        for(let i = 0; i < CivilService.length; i++) {
            if(CivilService[i]["CS_RA_CES_CSEE_DL"] == new_civil_service.getAttribute('data-type-service')) {
                CivilService.splice(i, 1)
                alert(JSON.stringify(CivilService));
            } 
        }
    });

    // Inserted
    new_civil_service.appendChild(td1);
    new_civil_service.appendChild(td2);
    new_civil_service.appendChild(td3);
    new_civil_service.appendChild(td4);
    new_civil_service.appendChild(td5);
    new_civil_service.appendChild(td6);
    td7.appendChild(button);
    new_civil_service.appendChild(td7);
    civil_service.appendChild(new_civil_service);
    alert(JSON.stringify(CivilService));
});





let WorkExperienceAdd = document.getElementById('WorkExperienceAdd');
WorkExperienceAdd.addEventListener('click', () => {
    let V_I_D_From = document.getElementById('V_I_D_From');
    let V_I_D_To = document.getElementById('V_I_D_To');
    let V_PosTitle = document.getElementById('V_PosTitle');
    let V_D_A_O_C = document.getElementById('V_D_A_O_C');
    let V_MS = document.getElementById('V_MS');
    let V_S_J_PG = document.getElementById('V_S_J_PG');
    let V_SOA = document.getElementById('V_SOA');
    let V_GOS = document.getElementById('V_GOS');


    let newDetail = {
        'V_I_D_From' : V_I_D_From.value,
        'V_I_D_To' : V_I_D_To.value,
        'V_PosTitle' : V_PosTitle.value,
        'V_D_A_O_C' : V_D_A_O_C.value,
        'V_MS' : V_MS.value,
        'V_S_J_PG' : V_S_J_PG.value,
        'V_SOA' : V_SOA.value,
        'V_GOS' : V_GOS.value
    }

    WorkExperience.push(newDetail);
    
    // container
    let work_experience = document.getElementById('work-experience');

    //
    let work_experience_child = document.createElement('tr');
    let td1 = document.createElement('td');
    let td2 = document.createElement('td');
    let td3 = document.createElement('td');
    let td4 = document.createElement('td');
    let td5 = document.createElement('td');
    let td6 = document.createElement('td');
    let td7 = document.createElement('td');
    let td8 = document.createElement('td');
    let td9 = document.createElement('td');

    work_experience_child.setAttribute("data-type-service", V_PosTitle.value);
    td1.innerText = `${V_I_D_From.value}`;
    td2.innerText = `${V_I_D_To.value}`;
    td3.innerText = `${V_PosTitle.value}`;
    td4.innerText = `${V_D_A_O_C.value}`;
    td5.innerText = `${V_MS.value}`;
    td6.innerText = `${V_S_J_PG.value}`;
    td7.innerText = `${V_SOA.value}`;
    td8.innerText = `${V_GOS.value}`;


    // New element tobe inserted
    let button = document.createElement('button');
    button.innerHTML = "Remove";
    button.setAttribute("class", "btn btn-dark");
    button.setAttribute("type", "button");
    button.addEventListener("click", () => {
        work_experience_child.remove();
        button.remove();

        for(let i = 0; i < WorkExperience.length; i++) {
            if(WorkExperience[i]['V_PosTitle'] == work_experience_child.getAttribute('data-type-service')) {
                WorkExperience.splice(i, 1)
                alert(JSON.stringify(WorkExperience));
            }
        }
    });

    // inserted
    work_experience_child.appendChild(td1);
    work_experience_child.appendChild(td2);
    work_experience_child.appendChild(td3);
    work_experience_child.appendChild(td4);
    work_experience_child.appendChild(td5);
    work_experience_child.appendChild(td6);
    work_experience_child.appendChild(td7);
    work_experience_child.appendChild(td8);
    td9.appendChild(button);
    work_experience_child.appendChild(td9);
    work_experience.appendChild(work_experience_child);
    alert(JSON.stringify(WorkExperience));
});


let VoluntaryAdd = document.getElementById('VoluntaryAdd');

VoluntaryAdd.addEventListener('click', () => {
    // Textboxes
    let NAOF = document.getElementById("NAOF");
    let VI_I_D_From = document.getElementById("VI_I_D_From");
    let VI_I_D_To = document.getElementById("VI_I_D_To");
    let VI_NOF = document.getElementById("VI_NOF");
    let VI_POS_NOW = document.getElementById("VI_POS_NOW");
    


    let newDetail = {
		"NAOF" : NAOF.value,
		"VI_I_D_From" : VI_I_D_From.value,
        "VI_I_D_To" : VI_I_D_To.value,
        "VI_NOF" : VI_NOF.value,
        "VI_POS_NOW" : VI_POS_NOW.value
	};

    VoluntaryWork.push(newDetail);

    // Container
    let voluntary_work = document.getElementById('voluntary-work');
    
    // New Element
    let children = document.createElement('tr');
    let td1 = document.createElement('td');
    let td2 = document.createElement('td');
    let td3 = document.createElement('td');
    let td4 = document.createElement('td');
    let td5 = document.createElement('td');
    let td6 = document.createElement('td');



    td1.innerText = `${NAOF.value}`;
    td2.innerText = `${VI_I_D_From.value}`;
    td3.innerText = `${VI_I_D_To.value}`;
    td4.innerText = `${VI_NOF.value}`;
    td5.innerText = `${VI_POS_NOW.value}`;


    children.setAttribute("data-type-naof", NAOF.value);
    
    let button = document.createElement('button');
    button.innerHTML = "Remove";
    button.setAttribute("class", "btn btn-dark");
    button.addEventListener("click", () => {
        children.remove();
        button.remove();

        for(let i = 0; i < VoluntaryWork.length; i++) {
            if(VoluntaryWork[i]["NAOF"] == children.getAttribute("data-type-naof")) {
                VoluntaryWork.splice(i, 1);
                alert(JSON.stringify(VoluntaryWork));
            }
        }
    });

    children.appendChild(td1);
    children.appendChild(td2);
    children.appendChild(td3);
    children.appendChild(td4);
    children.appendChild(td5);

    td6.appendChild(button);
    children.appendChild(td6);
    voluntary_work.appendChild(children);
    alert(JSON.stringify(VoluntaryWork));
});


let LADAdd = document.getElementById('LADAdd');

LADAdd.addEventListener('click', function() {
    // Textboxes
    let TOLADI_TP = document.getElementById("TOLADI_TP");
    let VII_I_D_From = document.getElementById("VII_I_D_From");
    let VII_I_D_To = document.getElementById("VII_I_D_To");
    let VII_NOF = document.getElementById("VII_NOF");
    let VII_TOLD = document.getElementById("VII_TOLD");
    let VII_POS_NOF = document.getElementById("VII_POS_NOF");


    let newDetail = 	{
		"TOLADI_TP" : TOLADI_TP.value,
		"VII_I_D_From" : VII_I_D_From.value,
        "VII_I_D_To" : VII_I_D_To.value,
        "VII_NOF" : VII_NOF.value,
        "VII_TOLD" : VII_TOLD.value,
        "VII_POS_NOF" : VII_POS_NOF.value
	};

    LAD.push(newDetail);

    // Container
    let LAD_Container = document.getElementById('LAD');
    
    // New Element
    let children = document.createElement('tr');
    let td1 = document.createElement('td');
    let td2 = document.createElement('td');
    let td3 = document.createElement('td');
    let td4 = document.createElement('td');
    let td5 = document.createElement('td');
    let td6 = document.createElement('td');
    let td7 = document.createElement('td');


    td1.innerText = `${TOLADI_TP.value}`;
    td2.innerText = `${VII_I_D_From.value}`;
    td3.innerText = `${VII_I_D_To.value}`;
    td4.innerText = `${VII_NOF.value}`;
    td5.innerText = `${VII_TOLD.value}`;
    td6.innerText = `${VII_POS_NOF.value}`;


    children.setAttribute("data-type-learning", TOLADI_TP.value);
    
    let button = document.createElement('button');
    button.innerHTML = "Remove";
    button.setAttribute("class", "btn btn-dark");
    button.addEventListener("click", () => {
        children.remove();
        button.remove();
        
        for(let i = 0; i < LAD.length; i++) {
            if(LAD[i]["TOLADI_TP"] == children.getAttribute("data-type-learning")) {
                LAD.splice(i, 1);
                alert(JSON.stringify(LAD));
            }
        }
    });

    children.appendChild(td1);
    children.appendChild(td2);
    children.appendChild(td3);
    children.appendChild(td4);
    children.appendChild(td5);
    children.appendChild(td6);

    td7.appendChild(button);
    children.appendChild(td7);
    LAD_Container.appendChild(children);
    alert(JSON.stringify(LAD));
}); 


let ReferencesAdd = document.getElementById('ReferencesAdd');

ReferencesAdd.addEventListener('click', () => {
     // Textboxes
    let RefName = document.getElementById("RefName");
    let RefAddress = document.getElementById("RefAddress");
    let RefTelNo = document.getElementById("RefTelNo");

    let newDetail = 	{
		"RefName" : RefName.value,
		"RefAddress" : RefAddress.value,
        "RefTelNo" : RefTelNo.value
	};

    References.push(newDetail);

    // Container
    let reference = document.getElementById('reference');
    
    // New Element
    let children = document.createElement('tr');
    let td1 = document.createElement('td');
    let td2 = document.createElement('td');
    let td3 = document.createElement('td');
    let td4 = document.createElement('td');


    td1.innerText = `${RefName.value}`;
    td2.innerText = `${RefAddress.value}`;
    td3.innerText = `${RefTelNo.value}`;

    children.setAttribute("data-type-name", RefName.value);
    
    let button = document.createElement('button');
    button.innerHTML = "Remove";
    button.setAttribute("class", "btn btn-dark");
    button.addEventListener("click", () => {
        children.remove();
        button.remove();
        
        for(let i = 0; i < References.length; i++) {
            if(References[i]["RefName"] == children.getAttribute("data-type-name")) {
                References.splice(i, 1);
                alert(JSON.stringify(References));
            }
        }
    });

    children.appendChild(td1);
    children.appendChild(td2);
    children.appendChild(td3);
    td4.appendChild(button);
    children.appendChild(td4);
    reference.appendChild(children);
    alert(JSON.stringify(References));
});



Submit.addEventListener('click', () => {
    let Surname = document.getElementById('Surname');
    let Firstname = document.getElementById('Firstname');
    let MiddleName = document.getElementById('MiddleName');

    let Sex = document.getElementsByName('Sex');
    let SexVal;

    for(let i = 0; i < Sex.length; i++) {
        if(Sex[i].checked) {
            SexVal = Sex[i].value;
        }
    }

    let CivilStatus = document.getElementsByName('CivilStatus');
    let CivilStatusVal;

    for(let i = 0; i < CivilStatus.length; i++) {
        if(CivilStatus[i].checked) {
            CivilStatusVal = CivilStatus[i].value;
        }
    }

    let Citizenship1 = document.getElementsByName('Citizenship1');
    let Citizenship1Val;

    for(let i = 0; i < Citizenship1.length; i++) {
        if(Citizenship1[i].checked) {
            Citizenship1Val = Citizenship1[i].value;
        }
    }

    let Citizenship2 = document.getElementsByName('Citizenship2');
    let Citizenship2Val;

    for(let i = 0; i < Citizenship2.length; i++) {
        if(Citizenship2[i].checked) {
            Citizenship2Val = Citizenship2[i].value;
        }
    }

    let TD = document.getElementsByName('TD');
    let TDVal;

    for(let i = 0; i < TD.length; i++) {
        if(TD[i].checked) {
            TDVal = TD[i].value;
        }
    }

    let FD = document.getElementsByName('FD');
    let FDVal;

    for(let i = 0; i < FD.length; i++) {
        if(FD[i].checked) {
            FDVal = FD[i].value;
        }
    }

    let AO = document.getElementsByName('AO');
    let AOVal;

    for(let i = 0; i < AO.length; i++) {
        if(AO[i].checked) {
            AOVal = AO[i].value;
        }
    }

    let CC = document.getElementsByName('CC');
    let CCVal;

    for(let i = 0; i < CC.length; i++) {
        if(CC[i].checked) {
            CCVal = CC[i].value;
        }
    }

    let CoV = document.getElementsByName('CoV');
    let CoVVal;

    for(let i = 0; i < CoV.length; i++) {
        if(CoV[i].checked) {
            CoVVal = CoV[i].value;
        }
    }

    let SFTS = document.getElementsByName('SFTS');
    let SFTSVVal;

    for(let i = 0; i < SFTS.length; i++) {
        if(SFTS[i].checked) {
            SFTSVVal = SFTS[i].value;
        }
    }

    let CNOLE = document.getElementsByName('CNOLE');
    let CNOLEVal;

    for(let i = 0; i < CNOLE.length; i++) {
        if(CNOLE[i].checked) {
            CNOLEVal = CNOLE[i].value;
        }
    }

    let RGS = document.getElementsByName('RGS');
    let RGSVal;

    for(let i = 0; i < RGS.length; i++) {
        if(RGS[i].checked) {
            RGSVal = RGS[i].value;
        }
    }

    let SIoPS = document.getElementsByName('SIoPS');
    let SIoPSVal;

    for(let i = 0; i < SIoPS.length; i++) {
        if(SIoPS[i].checked) {
            SIoPSVal = SIoPS[i].value;
        }
    }

    let IG = document.getElementsByName('IG');
    let IGVal;

    for(let i = 0; i < IG.length; i++) {
        if(IG[i].checked) {
            IGVal = IG[i].value;
        }
    }

    let PwD = document.getElementsByName('PwD');
    let PwDVal;

    for(let i = 0; i < PwD.length; i++) {
        if(PwD[i].checked) {
            PwDVal = PwD[i].value;
        }
    }

    let SP = document.getElementsByName('SP');
    let SPVal;

    for(let i = 0; i < SP.length; i++) {
        if(SP[i].checked) {
            SPVal = SP[i].value;
        }
    }

    let details = {
        'CSID' : CSID.value,
        'Surname' : Surname.value,
        'Firstname' : Firstname.value,
        'NameExtension' : NameExtension.value,
        'MiddleName' : MiddleName.value,
        'DateOfBirth' : DateOfBirth.value,
        'PlaceOfBirth' : PlaceOfBirth.value,
        'Sex' : SexVal,
        'CivilStatus' : CivilStatusVal,
        'Height' : Height.value,
        'Weight' : Weight.value,
        'BloodType' : BloodType.value,
        'GSIS' : GSIS.value,
        'PagIBIG' : PagIBIG.value,
        'PHILHEALTH' : PHILHEALTH.value,
        'SSS' : SSS.value,
        'TIN' : TIN.value,
        'AgencyNo' : AgencyNo.value,
        'Citizenship1' : Citizenship1Val,
        'Citizenship2' : Citizenship2Val,
        'DualCountry' : DualCountry.value,
        'ResHouse_Block_LotNo' : ResHouse_Block_LotNo.value,
        'ResStreet' : ResStreet.value,
        'ResSubdivision_Village' : ResSubdivision_Village.value,
        'ResBarangay' : ResBarangay.value,
        'ResCity_Municipality' : ResCity_Municipality.value,
        'ResProvince' : ResProvince.value,
        'ResZipCode' : ResZipCode.value,
        'PerHouse_Block_LotNo' : PerHouse_Block_LotNo.value,
        'PerStreet' : PerStreet.value,
        'PerSubdivision_Village' : PerSubdivision_Village.value,
        'PerBarangay' : PerBarangay.value,
        'PerCity_Municipality' : PerCity_Municipality.value,
        'PerProvince' : PerProvince.value,
        'PerZipCode' : PerZipCode.value,
        'TelephoneNumber' : TelephoneNumber.value,
        'MobileNumber' : MobileNumber.value,
        'EmailAdd' : EmailAdd.value,
        'Spouse_Surname' : Spouse_Surname.value,
        'Spouse_Firstname' : Spouse_Fistname.value,
        'Spouse_NameExtension' : Spouse_NameExtension.value,
        'Spouse_Middlename' : Spouse_Middlename.value,
        'Spouse_Employer_Businessname' : Spouse_Employer_Businessname.value,
        'Spouse_BusinessAddress' : Spouse_BusinessAddress.value,
        'Spouse_TelephoneNumber' : Spouse_TelephoneNumber.value,
        'Spouse_Children' : Spouse_Children,
        'NOF_Elementary' : NOF_Elementary.value,
        'NOF_Secondary' : NOF_Secondary.value,
        'NOF_Vocational' : NOF_Vocational.value,
        'NOF_College' : NOF_College.value,
        'NOF_Graduate' : NOF_Graduate.value,
        'BE_D_C_Elementary' : BE_D_C_Elementary.value,
        'BE_D_C_Secondary' : BE_D_C_Secondary.value,
        'BE_D_C_Vocational' : BE_D_C_Vocational.value,
        'BE_D_C_College' : BE_D_C_College.value,
        'BE_D_C_Graduate' : BE_D_C_Graduate.value,
        'POA_From_Elementary' : POA_From_Elementary.value,
        'POA_To_Elementary' : POA_To_Elementary.value,
        'POA_From_Secondary' : POA_From_Secondary.value,
        'POA_To_Secondary' : POA_To_Secondary.value,
        'POA_From_Vocational' : POA_From_Vocational.value,
        'POA_To_Vocational' : POA_To_Vocational.value,
        'POA_From_College' : POA_From_College.value,
        'POA_To_College' : POA_To_College.value,
        'POA_From_Graduate' : POA_From_Graduate.value,
        'POA_To_Graduate' : POA_To_Graduate.value,
        'HL_UE_Elementary' : HL_UE_Elementary.value,
        'HL_UE_Secondary' : HL_UE_Secondary.value,
        'HL_UE_Vocational' : HL_UE_Vocational.value,
        'HL_UE_College' : HL_UE_College.value,
        'HL_UE_Graduate' : HL_UE_Graduate.value,
        'YR_G_Elementary' : YR_G_Elementary.value,
        'YR_G_Secondary' : YR_G_Secondary.value,
        'YR_G_Vocational' : YR_G_Vocational.value,
        'YR_G_College' : YR_G_College.value,
        'YR_G_Graduate' : YR_G_Graduate.value,
        'Scho_AHR_Elementary' : Scho_AHR_Elementary.value,
        'Scho_AHR_Secondary' : Scho_AHR_Secondary.value,
        'Scho_AHR_Vocational' : Scho_AHR_Vocational.value,
        'Scho_AHR_College' : Scho_AHR_College.value,
        'Scho_AHR_Graduate' : Scho_AHR_Graduate.value,
        'CivilService' : CivilService,
        'WorkExperience' : WorkExperience,
        'VoluntaryWork' : VoluntaryWork,
        'LAD' : LAD,
        'TD' : TDVal,
        'FD' : FDVal,
        'FDDetails' : FDDetails.value,
        'AO' : AOVal,
        'AODetails' : AODetails.value,
        'CC' : CCVal,
        'CCDate' : CCDate.value,
        'CCSOC' : CCSOC.value,
        'CoV' : CoVVal,
        'CoVDetails' : CoVDetails.value,
        'SFTS' : SFTSVVal,
        'SFTSDetails' : SFTSDetails.value,
        'CNOLE' : CNOLEVal,
        'CNOLEDetails' : CNOLEDetails.value,
        'RGS' : RGSVal,
        'RGSDetails' : RGSDetails.value,
        'SIoPS' : SIoPSVal,
        'SIoPSDetails' : SIoPSDetails.value,
        'IG' : IGVal,
        'IGDetails' : IGDetails.value,
        'PwD' : PwDVal,
        'PwDDetails' : PwDDetails.value,
        'SP' : SPVal,
        'SPDetails' : SPDetails.value,
        'References' : References,
        'GIID' : GIID.value,
        'ID_L_PNO' : ID_L_PNO.value,
        'D_Pol' : D_Pol.value
    }

    const myJson = JSON.stringify(details);
    window.location = `assets/insert.php?Surname=${Surname.value}&Firstname=${Firstname.value}&MiddleName=${MiddleName.value}&info=${myJson}`;
});