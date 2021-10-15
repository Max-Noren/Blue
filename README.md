README

## Description:
With the help of this web application a commuter in Gothenburg can calculate the carbon footprint of their commute depending on their choice of transportation. Comparing different car types, bike types, walking and using public transport. The application also includes features to compare time, cost and other information to help commuters make a conscious and informed decision for the environment and their commute. 

Link to website:
https://blue.felixbrunnegard.se
(Can also be run locally with XAMPP)


## Program - Structure
The code of the program is split between a main function, ‘index.php’, and several helper functions separate php files in the ‘Code’ folder.  ‘Index.php’ is the main code and contains the startup interface and integrates all parts of the program. The remaining helper functions are sorted different php files with their filename corresponding to different categories, these include:
* costs.php -> Contain cost related function
* emission.php -> Contain emission related function
* travelinfo.php -> Contain function that provides travel info such as time and distance using OpenRouteService, not including Public Transport.
* display.php -> Contain functions that display output data
* PublicTransport.php -> Contain function that provides time estimate for public transport using Västtrafik API

### Extra
* 'style.css' contain a majority of CSS code for style elements such as startup interface and table.

* The ‘test’ folder is for future potential tests if deemed necessary.

## External resources:
Scrum Board on Trello:
https://trello.com/b/zNDrUmN4

Github Program and important documents:
https://github.com/Max-Noren/Blue

Who's who in Github:
* Felicia Berggren - dex2503
* Felix Brunnegård - felixbrunnegard
* Lisa Löving - lisaloving
* Max Norén - Max-Noren
* Joel Persson - jopers
* Johanna Schüldt - Yoschu
* Irja Vuorela - Snarkjakten

Google Drive for personal notes and collaboration:
https://drive.google.com/drive/folders/1k7Uuw1GjZzPXnhWh3KDRiSEmxrUMD90Z?usp=sharing

*(Notice that the shared Drive does not contain vital parts of the project and is merely used as a tool for cooperation, notes and brainstorming. A few meeting protocols are kept in the folder "Mötesprotokoll". For final versions of important documents such as Social  contract, Team Reflections and Definition of Done, please refer to Github repository above)

## Developer documents (see DevDocuments folder)

Definition of done:
https://github.com/Max-Noren/Blue/blob/main/DevDocuments/Definition%20of%20done.pdf

Social contract:
https://github.com/Max-Noren/Blue/blob/main/DevDocuments/Social%20Contract%20Blue.txt

Project scope:
https://github.com/Max-Noren/Blue/blob/main/DevDocuments/Project%20Scope.pdf

KPIs
https://github.com/Max-Noren/Blue/blob/main/DevDocuments/KPI's%20blue%20team.pdf

Mockup:
https://github.com/Max-Noren/Blue/blob/main/DevDocuments/Blue_Mockup_2.0.pdf

## Individual and team reflections: Reflections can be found in the folder ‘Reflections’ and is organized in individual week folders. Team reflections are only present from week 3 and onward while individual reflections can be found in every week for all team members.

https://github.com/Max-Noren/Blue/tree/main/Reflections

## Sources: See the Github wiki for our sources.
https://github.com/Max-Noren/Blue/wiki/Sources


