DROP DATABASE IF EXISTS auction;

CREATE DATABASE auction CHARACTER SET utf8 COLLATE utf8_general_ci;

USE auction;

CREATE TABLE `bids` (
  `bid_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `bidder_name` varchar(150) NOT NULL,
  `details` longtext NOT NULL,
  `bid_amount` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `bids` (`bid_id`, `item_id`, `bidder_name`, `details`, `bid_amount`) VALUES
(6, 1, 'Saurya Dhwoj Acharya', 'This is the one of the best product I have ever seen. How long it will take to ship to my address?', '400.30'),
(8, 1, 'Rujal Shakya', 'This is the best product. I love it.', '300.30'),
(9, 2, 'Barsha Subedi', 'Best product blah blah blah', '300.25'),
(10, 2, 'Dipesh Chhetri', 'One of the best product.', '320.40');


CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` longtext NOT NULL,
  `image_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `items` (`id`, `name`, `description`, `image_url`) VALUES
(1, 'Microsoft Surface Pro 4', 'Surface Pro 4 is the proportions of a sheet of paper so that it feels familiar in your hands. It goes from tablet to laptop in a snap with the multi-position Kickstand and improved keyboard.Powered by Windows 10, Surface Pro 4 turns from a tablet into a full powered laptop while running all of your desktop software.The 12.3 inch PixelSense display has extremely high contrast and low glare, giving you a picture rivaling real life.More powerful and lighter than ever before at 1.69lbs (766 grams). Surface Pro 4 is the most versatile and productive device you&apos;ll ever use. With the multi-position kickstand and an improved Type Cover,1 it transforms into a fully functioning laptop running desktop software.Surface Pro 4 is your mobile workstation, with Intel Core processors that allow you to run multiple programs.', 'uploads/surfacepro.jpg'),
(2, 'Raspberry Pi', 'The Raspberry Pi 3 Model Bis the latest version of the Raspberry Pi, a tiny credit card size computer. Just add a keyboard, mouse, display, power supply, micro SD card with installed Linux Distribution and you''ll have a fully fledged computer that can run applications from word processors and spreadsheets to games.As the Raspberry Pi 3 supports HD video, you can even create a media centre with it. The Raspberry Pi 3 Model B is the first Raspberry Pi to be open-source from the get-go, expect it to be the defacto embedded linux board in all the forums.', 'uploads/raspberrypi.jpg'),
(3, 'Macbook Air', 'MacBook Air is unbelievably thin and light. But we also designed it to be powerful, capable, durable, and enjoyable to use, with enough battery life to get you through the day. That&apos;s the difference between a notebook that&apos;s simply thin and light and one that&apos;s so much more.Even at less than an inch thin, MacBook Air sets a pretty high standard - by making flash storage standard. Flash chips are very compact, allowing MacBook Air to be incredibly thin and light. Flash is also solid state, meaning there are no moving parts. Which makes it reliable, durable, and quiet. And it takes up much less space - about 90 percent less, in fact. That creates room for other important things, like a bigger battery. So you have a notebook that weighs almost nothing and runs for hours on a single charge. That&apos;s mobility mastered.', 'uploads/macbook.jpg'),
(4, 'Iphone 6S Plus', 'Apple iPhone 6s Plus smartphone was launched in September 2015. The phone comes with a 5.50-inch touchscreen display with a resolution of 1080 pixels by 1920 pixels at a PPI of 401 pixels per inch. The Apple iPhone 6s Plus is powered by A9 processor and it comes with 2GB of RAM. The phone packs 16GB of internal storage cannot be expanded. As far as the cameras are concerned, the Apple iPhone 6s Plus packs a 12-megapixel primary camera on the rear and a 5-megapixel front shooter for selfies. The Apple iPhone 6s Plus runs iOS 9 and is powered by a 2750mAh non removable battery. It measures 158.20 x 77.90 x 7.30 (height x width x thickness) and weighs 192.00 grams. The Apple iPhone 6s Plus is a single SIM (GSM) smartphone that accepts a Nano-SIM. Connectivity options include Wi-Fi, GPS, Bluetooth, NFC, 4G (with support for Band 40 used by some LTE networks in India). Sensors on the phone include Proximity sensor, Ambient light sensor, Accelerometer, and Gyroscope. ', 'uploads/iphone6splus.jpg');

ALTER TABLE `bids`
  ADD PRIMARY KEY (`bid_id`),
  ADD KEY `item_id` (`item_id`);

ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);
 
ALTER TABLE `bids`
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);