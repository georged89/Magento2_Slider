Installation:

composer config repositories.magento2-slider vcs https://github.com/georged89/Magento2_Slider.git

composer require georged/magento2-slider:dev-master


Setup:

Admin > GeorgeD > SliderManager > Add New Banner
Name - the name of the banner
Load Image - image uploader
Image Link - the link of the image that is executed on click/tap on image
Link text - text displayed on the image
Slide position - the position of the banner

You can also set the order direction of the images Ascending or Descending by setting it in:
Stores > Configuration > GeorgeD > GeorgeD Slider > Slider Config > Slides Order Direction


After you added the slider banners, you can create an widget and insert it wherever you desire:
Admin > Content > Widgets > Add Widget.
To add the slider on homepage as a hero image/banner slider, in the Layout Updates section select:
- Display on = Specific Page 
then
- Page: CMS Home Page (or your custom homepage name)
- Container: Main Content Top

Click on save.
After you refresh your cache, the slider that you configured in the Slider Manager section, should show up on your desired location.

