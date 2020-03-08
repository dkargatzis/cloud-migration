# cloud-migration
Cloud migration project is a platform that allows you to migrate a virtual machine between two Homogeneous but also  Heterogeneous Cloud Environments. The project utilizes the Openstack’s and VMware’s REST API to allow users to perform migration.
<br><br>
Specifically, you can transfer a virtual machine from an OpenStack platform (e.g. Intellicloud  to other OpenStack system (e.g. FIWARE Lab) or from OpenStack platform (e.g. FIWARE Lab) to a VMWare based platform. 

Read the publication at <a href="https://ieeexplore.ieee.org/document/8080393">IEEE Xplore</a>

<h3>Prerequisites</h3>

<ul>
  <li>a Linux distribution</li>
  <li><a href="http://www.qemu.org/">Qemu</a> command-line tool, is an open source machine emulator and virtualizer.</li>
  <li>Curl (Client URL Library) for PHP</li>
  <li>Fiware account</li>
  <li>Intellicloud account</li>
  <li>StratoGen account</li>
</ul>

<h3>Getting Started</h3>

Clone `cloud-migration` repository to your server.
<br>
Change `assets` folder permissions to `rw-`
<br>
Now browse to the app at `server-ip/cloud-migration`

<h3>Check application</h3>

Browse at <a href="http://147.27.60.220/migration/">cloud-migration</a>

<h3>Directory Layout</h3>


```
/                           --> all of the source files for the application
  index.php                 --> start page
  procedure.php             --> Fiware authentication page
  download.php              --> all Fiware operations (list of instances/images, snapshot instance, download/upload image)
  intellicloud-proc.php     --> Intellicloud authentication page
  intellicloud-download.php --> all intellicloud operations (list of instances/images, snapshot instance, download image)
  upload-proc.php           --> Stratogen (VMware) authenticcation page
  tools.php                 --> all VMware operations (create new VApp, upload descriptor, upload reference file (image)
  Assets/
    css/                      --> stylesheet files
    images/                   --> all necessary GUI images 
    file-ref/                 --> the directory where download image stored 
    
    FIWARE.php                --> HTTP requests for Fiware operations 
    intellicloud.php          --> HTTP requests for Intellicloud operations 
    Images--Fiware.php        --> HTTP request for list of Fiware images
    Images-Intellicloud.php   --> HTTP request for list of Intellicloud images
    Servers--Fiware.php       --> HTTP request for list of Fiware instances
    Servers-Intellicloud.php  --> HTTP request for list of Intellicloud instances
    Templates-vMWare.php      --> HTTP request fr list of VMware Templates
    descr.ovf                 --> OVF descriptor (XML file) to initiate virtual machine 
    stratogen.php             --> HTTP requests for Stratogen (VMware) operations 

```   

## License

GNU GENERAL PUBLIC LICENSE

Copyright © 2017 [Dimitris Kargatzis](https://www.linkedin.com/in/dimitris-kargatzis-1385a2101/)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. 

IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
