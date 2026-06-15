-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2026 at 05:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_hotel_book`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `bk_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `tc_id` int(11) NOT NULL,
  `tp_id` int(11) NOT NULL,
  `bk_person` int(3) DEFAULT NULL,
  `bk_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`bk_id`, `c_id`, `tc_id`, `tp_id`, `bk_person`, `bk_date`, `start_date`, `end_date`) VALUES
(1, 6, 0, 0, NULL, NULL, NULL, NULL),
(2, 7, 0, 0, NULL, NULL, NULL, NULL),
(3, 10, 0, 0, 7, '0000-00-00', NULL, NULL),
(4, 10, 0, 0, 7, '0000-00-00', NULL, NULL),
(5, 20, 0, 0, 3, NULL, NULL, NULL),
(6, 20, 0, 0, 3, NULL, NULL, NULL),
(7, 20, 0, 0, 3, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cancellation_details`
--

CREATE TABLE `cancellation_details` (
  `can_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `hbk_id` int(11) NOT NULL,
  `pmt_id` int(11) NOT NULL,
  `can_charge` double DEFAULT NULL,
  `ref_amt` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cancellation_details`
--

INSERT INTO `cancellation_details` (`can_id`, `c_id`, `hbk_id`, `pmt_id`, `can_charge`, `ref_amt`) VALUES
(1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `f_name` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `mob_no` int(14) NOT NULL,
  `email` varchar(70) NOT NULL,
  `query` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`f_name`, `addr`, `mob_no`, `email`, `query`) VALUES
('Mira Paul', '14/D, Chowbaga road,kolkata-700039', 1804552820, 'mirapaul@gmail.com', 'Is there any discount for senior citizens??');

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(50) DEFAULT NULL,
  `c_addr` varchar(70) DEFAULT NULL,
  `c_mob` varchar(15) DEFAULT NULL,
  `c_gen` varchar(10) DEFAULT NULL,
  `c_email` varchar(40) DEFAULT NULL,
  `c_dob` varchar(20) DEFAULT NULL,
  `c_pswd` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`c_id`, `c_name`, `c_addr`, `c_mob`, `c_gen`, `c_email`, `c_dob`, `c_pswd`) VALUES
(3, 'Param Prodhan', 'Govt. colony      ', '8961335468', 'male', 'param@gmail.com', '22/10/1998', 'param@123'),
(4, 'Sudev Ghosh', '6/24, Brahmapur Shiv Mandir Road, Kolkata-700096', '9674651747', 'MALE', 'sudev62@gmail.com', '10/02/1989', 'sudev'),
(7, 'MIRA PAUL', '14/D, CHOWBAGA ROAD, KOLKATA-700039      ', '9804552821', 'female', 'mpaul@gmail.com', '25/1/1963', 'paul');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `emp_id` int(11) NOT NULL,
  `emp_name` varchar(30) DEFAULT NULL,
  `emp_mob` varchar(15) DEFAULT NULL,
  `emp_email` varchar(30) DEFAULT NULL,
  `emp_pswd` varchar(10) DEFAULT NULL,
  `emp_type` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`emp_id`, `emp_name`, `emp_mob`, `emp_email`, `emp_pswd`, `emp_type`) VALUES
(1, 'Sudev Ghosh', '9674651747', 'sudev62@gmail.com', 'sudev', 'C'),
(3, 'Param Prodhan', '8961600528', 'param@gmail.com', 'param@123', 'A'),
(4, 'Jayanta Paul', '9038058780', 'jayanta0710@gmail.com', 'zolo', 'E');

-- --------------------------------------------------------

--
-- Table structure for table `hotelbooking_details`
--

CREATE TABLE `hotelbooking_details` (
  `hbk_id` int(11) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `h_id` int(11) DEFAULT NULL,
  `rm_type` varchar(10) NOT NULL,
  `str_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `bk_date` date DEFAULT NULL,
  `rooms` int(11) DEFAULT 1,
  `adults` int(11) DEFAULT 1,
  `children` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hotelbooking_details`
--

INSERT INTO `hotelbooking_details` (`hbk_id`, `c_id`, `h_id`, `rm_type`, `str_date`, `end_date`, `bk_date`, `rooms`, `adults`, `children`) VALUES
(1, 2, 3, 'ac', '2015-09-15', '2015-09-16', '2015-09-01', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_details`
--

CREATE TABLE `hotel_details` (
  `h_id` int(11) NOT NULL,
  `h_name` varchar(50) DEFAULT NULL,
  `h_loc` varchar(70) DEFAULT NULL,
  `h_city` varchar(30) DEFAULT NULL,
  `st_id` int(11) DEFAULT NULL,
  `h_rate` varchar(7) NOT NULL,
  `h_desc` varchar(400) NOT NULL,
  `ac_rm` int(3) NOT NULL DEFAULT 0,
  `nac_rm` int(3) NOT NULL DEFAULT 0,
  `avlac_rm` int(3) NOT NULL DEFAULT 0,
  `avlnac_rm` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hotel_details`
--

INSERT INTO `hotel_details` (`h_id`, `h_name`, `h_loc`, `h_city`, `st_id`, `h_rate`, `h_desc`, `ac_rm`, `nac_rm`, `avlac_rm`, `avlnac_rm`) VALUES
(1, 'Sea Princess Beach Resort', 'Wandoor', 'PortBlair-744101', 1, 'Rs.3999', 'Sea Princess Beach Resort ,located along the shorelines of the Wandoor Beach is a perfect getaway from the monotonous life. It offers luxurious accomodation with facilities that speack volumes for its 3 star status.  ', 0, 0, 0, 0),
(2, 'Shompen Hotel', 'Middle Point', 'Portblair-744101', 1, 'Rs.4000', 'located 3kms from the harbour,this property contains 32 rooms with a private balcony,and can be checked into by 10 a.m. Guests are offered scrumptious fare in the multi-cuisine restaurant. There is also a travel desk that facilitates car rentals.', 0, 0, 0, 0),
(3, 'Fortune Resort Bay Island ', 'Marine hill', 'Port Blair-744101', 1, 'Rs.7200', 'Fortune Bay Island Resort is located in Marine hill,administrate the rain forest island of the Andaman. Overlooking the Bay of bengal, this i4 star resort is built with the beautiful red timber,Padouk.', 0, 0, 0, 0),
(4, 'Hotel Sentinel', 'Phoenix Bay, Andaman District', 'Port Blair-744101', 1, 'Rs.5000', 'Located at Phoenix Bay,Hotel Sentinel is addmired for its home-like ambience and splendid interiors. It comprises 40 carefully design rooms with facilities like satellite TV, WIFI.', 0, 0, 0, 0),
(5, 'Sinclairs Bayview', 'South Point', 'Portblair-744101', 1, 'Rs.3400', 'Surrounded by clear saphire sea waters,golden shorees and fascinating flora and fauna. Hotel Sinclairs Bayview offers just the perfect accomodation for vacationers in Port blair, commanding a view of the Bay of Bengal.', 0, 0, 0, 0),
(6, 'Sai Priya Beach Resort', 'Rushikonda', 'Visakhapatnam-530045', 2, 'Rs.2000', 'Situated in Rushikunda, Sai Priya Beach Resorts is the vicnity of pristine and clear  beaches. It offers awe-inspiring scenery of torquoise blue sea water of the Indian Ocean with tits waves stroking against the white sand with a 3 star property.', 0, 0, 0, 0),
(7, 'Novotel', 'Beach Road', 'Visakhapatnam-530002', 2, 'Rs.7000', 'This premier hotel is located at Varun Beach in Vishakhapatnam. Offering rooms & suits of all extravagances along with spectacular views of Bay of Bengal. Restaurants serving Indian and International cuisine and a Bar overlooking the ocean.', 0, 0, 0, 0),
(8, 'Fortune Inn Sree Kanya', 'Dwaraka Nagar', 'Visakhapatnam-530016', 2, 'Rs.2700', 'Viskhapatnam is located on the eastern shore of India,nestled amongst the hills of the Eastern Ghats and facing the Bay of Bengal to the East. It is also popularly referred asto as Vizag. ', 0, 0, 0, 0),
(9, 'Hotel Daspalla', 'Suryabagh', 'Visakhapatnam-530020', 2, 'Rs.3000', 'Hotel Daspalla is located strategically in Suryabagh, close to the railway station and airport. It is a 3star property. Providing  travel assistance,doctor-on-call,car rental,currency exchange and airport pickup.', 0, 0, 0, 0),
(10, 'Dolphin Hotel', 'Dabagardens', 'Visakhapatnam-530020', 2, 'Rs.4000', 'The Ramoji Group\'s Dolphin Hotel is a 4 star property that is situated in Dabagarden. Surrounded by beautiful Gardens./ Guest can choose from 84 executive rooms,55 premium rooms,4 delux suitsandf two executive suits.The hotel provide specious banqueat hall that are outfited with state-of-the-art facilities.', 0, 0, 0, 0),
(11, 'Radisson Blu Hotel', 'West Delhi', ' New Delh110063', 3, 'Rs.6300', 'This contemporary hotel is located just 12 miles from Connaught Place. A total of 178 designer guest rooms are available and include 21 spacious suites designed in synchronization with the Neo-Gothic theme of the hotel and include complimentary breakfast. An exceptional range of on-site dining options, include: Level 2, a 24/7 diner with interactive show kitchens, the Indyaki and an Indian special', 0, 0, 0, 0),
(12, 'Tavisha Hotel', 'Friends Colony', 'New Delhi-110065', 3, 'Rs.2000', 'Hotel Tavisha has 54 sophisticated rooms and an imposing 4 storey \r\n\r\nbuilding to its credit. It offers a lovely blend of gracious \r\n\r\nhospitality and modern comforts. The hotel is located in the bustling \r\n\r\ncity of New Delhi. Guests can indulge in relaxing spa services on a \r\n\r\nsurcharge, sip some coffee at the caf?, workout at the gym and enjoy a \r\n\r\ngourmet meal at the restaurant. Other amenit', 0, 0, 0, 0),
(13, 'Anya hotel', 'Golf Course Road', 'New Delhi-110037', 3, 'Rs.6000', 'Meaning different in Sanskrit, Anya is the perfect name for this \r\n\r\nhotel, which presents worldly sophistication with a splash of Indian \r\n\r\npanache and contemporary cool in the soaring commercial hub of Delhi. \r\n\r\nLocated on the prestigious DLF Golf Course road, the hotel has a \r\n\r\nfitting mantra - luxury with an undercurrent of minimalism and it comes \r\n\r\nalive everywhere, from the spacious sui', 0, 0, 0, 0),
(14, 'Radisson Blu, Dwarka', 'Airport Zone', 'New Delhi-110078', 3, 'Rs.5500', 'Located in Dwarka and about 10 km from the Domestic Airport, \r\n\r\nRadisson Blu hotel in New Delhi offers unmatched service and utmost \r\n\r\ncomforts to the guests. It is an ideal option to stay, comprising of \r\n\r\n273 elegantly designed and fully furnished rooms with free Wi-Fi. \r\n\r\nDining options include \'Rice\', The Pan-Asian Restaurant to relish a \r\n\r\nculinary delight and \'Spring\' offering wide rang', 0, 0, 0, 0),
(15, 'The Metropolitan Hotel and Spa', 'Connaught Place', 'New Delhi-110001', 3, 'Rs.6300', 'Located in the posh area of Connaught Place, The Metropolitan Hotel \r\n\r\nand Spa is a preferable choice for business travellers and holiday-\r\n\r\nmakers. Though this 5-star property is situated in the crowded city of \r\n\r\nDelhi, it provides guests a mellow environment to spend peaceful \r\n\r\nvacations. The 185 rooms and suites in this majestic hotel are \r\n\r\nclassified as Deluxe Rooms, Club Rooms, Execut', 0, 0, 0, 0),
(16, 'Platinum Hotel', 'Jawahar  Road', 'Rajkot-360001', 4, 'Rs.2000', 'Dream of a luxurious stay, soothing ambiance, contemporary d?cor and \r\n\r\nPlatinum Hotel, a luxury hotel in Rajkot is sure to fulfill your \r\n\r\ndreams. Strategically located just a kilometer away from the railway \r\n\r\nstation, race course and just 3 kilometers from the airport, this 70-\r\n\r\nroom hotel is indeed an ideal place to stay. Standing tall in the city \r\n\r\ncenter, this hotel boasts of an excel', 0, 0, 0, 0),
(17, 'The Grand Bhagwati Seasons Hotel', 'Kalavad Road', 'Rajkot-360005', 4, 'Rs.2999', 'Located on Kalawad Road, The Grand Bhagwati Seasons is a 5-star \r\n\r\nproperty having highly advanced facilities and diligent workforce. \r\n\r\nGuest\'s comfort tops the priority list of the hotel and therefore it \r\n\r\nnever fails to provide the same with its courteous service. Its elegant \r\n\r\ninteriors and charming atmosphere have earned it plethora of \r\n\r\ntestimonials. The central location of the hotel', 0, 0, 0, 0),
(18, 'Umaid Bhawan-A Heritage Home', 'Bani Park', 'Jaipur-302016', 4, 'Rs.3399', 'Umaid Bhawan offers a wide range of personalized services and \r\n\r\nfacilities to help make your stay in Jaipur a memorable one. They can \r\n\r\ntake a dip in the swimming pool or keep in touch with the World at the \r\n\r\nbusiness center with Internet connection. The hotel serves good Indian \r\n\r\ncuisine and the guests can dine at any of the restaurants namely, \r\n\r\nRisala, Pillars, Kebab Corner and Marwar', 0, 0, 0, 0),
(19, 'Jaipur Inn', 'Bani Park', 'Jaipur-302016', 4, 'Rs.1499', 'Hotel Jaipur Inn is located in Bani Park area, in the vicinity of \r\n\r\nthe central bus station, railway station and Sanganer Airport. In \r\n\r\noperation since 1970s, Jaipur Inn is one of the rarest hotels to have \r\n\r\nits origin in a camp site. The hotel has maintained its tradition of \r\n\r\noffering comfortable accommodation options to business as well as \r\n\r\nleisure travellers. There are 25 air-condit', 0, 0, 0, 0),
(20, 'The Theme', 'Tonk Road', 'Jaipur-302029', 4, 'Rs.2199', 'This marvelous architectural splendor welcomes you to its grandeur \r\n\r\nand aura in Jaipur, the pink city of India. Nestled in the heart of the \r\n\r\ncity and conveniently located at a distance of 6 kilometers from the \r\n\r\nairport, this 48-room hotel is a must-stay option in Jaipur. The bevy \r\n\r\nof dining option include: Bon Voyage, an all day dining restaurant \r\n\r\nwhich serves cuisines from across t', 0, 0, 0, 0),
(21, 'Hotel Willlow Banks', 'Tha Mall', 'Shimla-171001', 5, 'Rs.7000', 'Standing on The Mall Road, Hotel Willow Banks offers breathtaking \r\n\r\nviews of the majestic Himalayan Range. This 3-star property was \r\n\r\nestablished in the year 1871 and is now offering quality accommodation \r\n\r\nto tourists coming to Shimla. Guests have showered this hotel with a \r\n\r\nnumber of testimonials for its old-world charm and cheerful ambience.\r\n', 0, 0, 0, 0),
(22, 'Shimla Havens Resort', 'Summer Hill', 'Shimla-171005', 5, 'Rs.6999', 'Nestled amid Pine and Cedar trees and just a kilometer away from the \r\n\r\nSummer hill railway station, Shimla Havens Resort is an apt for those \r\n\r\nlooking for a memorable holiday. A total of 21 well-appointed rooms, \r\n\r\ndesigned with teak floors provide spectacular view of the majestic \r\n\r\nmountain ranges. \'The Cedar\' serves a scrumptious spread of Indian, \r\n\r\nContinental and Chinese cuisine, maki', 0, 0, 0, 0),
(23, 'Citrus Manali Resorts', 'Chandigarh Manali Highway', 'Manali-175131', 5, 'Rs.2499', 'Live life amidst the natural ambiance of this 5Star riverside \r\n\r\nresort, which is 40 kms from Kullu. A total of 112 centrally-heated \r\n\r\nrooms are available and a restaurant-cum-coffee shop is also maintained \r\n\r\nwithin, which is open from 7.00 am to midnight. Guests are entertained \r\n\r\nwith an organized barbecue night complimented with ghazal performance \r\n\r\nin its manicured lawns during the sum', 0, 0, 0, 0),
(24, 'Hyatt Amritsar', 'GT Road', 'Amritsar-143001', 5, 'Rs.3499', 'Nestled in the heart of Amritsar city and 10 minutes from the Golden \r\n\r\nTemple is Hyatt Amritsar. This luxury hotel offers a perfect \r\n\r\naccommodation for business and leisure travelers. Hyatt Amritsar offers \r\n\r\n248 elegantly appointed guestrooms including suites which are on the \r\n\r\nfourth floor of the hotel to ensure panoramic views of the city. Rooms \r\n\r\nhave a sleek contemporary design with ', 0, 0, 0, 0),
(25, 'Golden Tulip Aritsar', 'GT Road', 'Amritsar-143001', 5, 'Rs.3099', 'Located on G.T. Road, Golden Tulip is a 4-star hotel that offers \r\n\r\nlavish accommodation with unmatched services and facilities. This \r\n\r\nrenowned establishment enjoys proximity to the airport, railway station \r\n\r\nand various tourist attractions of the city. Its strategic location and \r\n\r\ntop-of-the-line hospitality make it ideal for both business and \r\n\r\nrecreational travellers.', 0, 0, 0, 0),
(26, 'Yasmin Resort', 'Hyderpora Chowk', 'Srinagar-190005', 6, 'Rs.2900', 'Have a fun-filled vacation in Srinagar amidst snow capped mountains, \r\n\r\nbeautiful lakes and lush greenery. Yasmin Resort in Srinagar is located \r\n\r\nat a distance of 10 mins away from Srinagar International airport and \r\n\r\nMughal Gardens. High-speed internet service provided here lets you stay \r\n\r\nconnected with your dear ones. Travel desk provides assistance related \r\n\r\nto tours. It consists of 1', 0, 0, 0, 0),
(27, 'Hotel Comrade Inn', 'Raj Bagh', 'Srinagar-190008', 6, 'Rs.4000', 'Comrade Inn, Srinagar is an opulent boutique property located in the \r\n\r\nheart of the city, Rajbagh. Designed in contemporary style, the hotel \r\n\r\noffers ultimate comfort and luxury to its guests. The in-house fine \r\n\r\ndining restaurant serves its guests with the best of Indian, \r\n\r\nContinental and Kashmiri cuisines. Spacious banquet-cum-conference hall \r\n\r\nis also available, which is perfect for ', 0, 0, 0, 0),
(28, 'Batra Hotel', 'Dalgate', 'Srinagar-190001', 6, 'Rs.6000', 'Experience the beauty of Srinagar with utmost serenity at Batra \r\n\r\nHotel and Residences. It is located 17 kilometers away from Srinagar \r\n\r\nairport. This two floored hotel boasts of 18 well furnished rooms, \r\n\r\nsmokers are provided with varied smoking rooms as well. Guests are been \r\n\r\nprovided with standard hotel benefits like 24 hour front desk and free \r\n\r\nparking space for vehicles.', 0, 0, 0, 0),
(29, 'Hotel Mirage', 'Raj Bagh', 'Srinagar-190008', 6, 'Rs.4500', 'Hotel Mirage is placed in the most beautiful city, Srinagar, close \r\n\r\nto Dal Lake at the distance of 5 kms away. This site leads to an easy \r\n\r\nway to every tourist place around the city. As well provides a rich and \r\n\r\na quality accommodation. This economical hotel promises free parking, \r\n\r\nroom service and suitable for family with children.', 0, 0, 0, 0),
(30, 'New Jacquline Group of Houseboats', 'Nagin Lake', 'Srinagar-190001', 6, 'Rs.3500', 'Standing beautifully at the edges of Nageen Lake and carved in \r\n\r\ntraditional wooden interiors, New Jacquline Houseboats is the place to \r\n\r\nenjoy a memorable and lovely holiday. There are six Wi-Fi enabled rooms \r\n\r\nto stay connected with friends and business associates. Guests can also \r\n\r\ndining in the beautifully designed dining hall. Other guest amenities \r\n\r\ninclude: breakfast service, free', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `login_id` int(11) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `login_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`login_id`, `c_id`, `login_time`) VALUES
(2, 3, '2015-08-11');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `pmt_id` int(11) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `hbk_id` int(11) NOT NULL,
  `pmt_amt` double DEFAULT NULL,
  `pmt_date` date DEFAULT NULL,
  `pmt_status` varchar(30) DEFAULT NULL,
  `pmt_type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`pmt_id`, `c_id`, `hbk_id`, `pmt_amt`, `pmt_date`, `pmt_status`, `pmt_type`) VALUES
(1, 2, 2, 3999, '2015-08-12', 'Confirm', 'NEFT'),
(2, 1, 3, 4999, '2015-08-20', 'Confirm', 'Debit Card'),
(16, 0, 0, NULL, '0000-00-00', '', ''),
(17, 0, 0, NULL, '0000-00-00', '', ''),
(18, 0, 0, NULL, '0000-00-00', '', ''),
(19, 0, 0, NULL, '0000-00-00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `place_details`
--

CREATE TABLE `place_details` (
  `p_id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL,
  `p_name` varchar(100) DEFAULT NULL,
  `p_details` varchar(1200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `place_details`
--

INSERT INTO `place_details` (`p_id`, `st_id`, `p_name`, `p_details`) VALUES
(1, 1, 'PORT BLAIR', '<b>Port Blair</b> is the largest town and a municipal council in Andaman district in the Andaman Islands and the capital of the Andaman and Nicobar Islands,a union territory of India.'),
(2, 2, 'VISAKHAPATNAM/VIZAG', 'The golden beaches at <b>Visakhapatnam</b>, the one million year old limestone caves at Borra, picturesque Araku Valley, hill resorts of Horsley Hills, river Godavari racing through a narrow gorge at Papi Kondalu, waterfalls at Ettipotala, Kuntala and rich bio-diversity at Talakona, are some of the natural attractions of the state.'),
(3, 3, 'NEW DELHI-AGRA-MATHURA-VRINDAVAN', '<b>Delhi</b> is the capital union territory of India. New Delhi is famous for its British colonial architecture and tree-lined boulevards. Delhi is home to numerous political landmarks, national museums, Islamic shrines, Hindu temples.'),
(4, 4, 'AHMEDABAD-JAIPUR-BIKANER-JAISALMIR.', '<b>Ahmdabad</b> is the largest city and former capital of the western Indian state of Gujarat. it is the sixth-largest city and seventh-largest metropolitan area of India.\r\n<b>Jaipur</b> is the capital and largest city of the Indian state of Rajasthan in Northern India.\r\n<b>Bikaner</b> is a city in the northwest of the state of Rajasthan in northern India.'),
(5, 5, 'SHIMLA-KULU-MANALI-AMRITSAR', '<b>Shimla</b> is the capital city of Himachal Pradesh India.\r\n<b>Kulu</b> is the capital town of the Kullu District in the Indian state of Himachal Pradesh.\r\n<b>Manali</b> is a hill station nestled in the mountains of the Indian state of Himachal Pradesh.\r\n<b>Amritsar</b> is one of the largest cities of the Punjab state in India.'),
(6, 6, 'SRINAGAR', '<b>Srinagar</b> is the summer capital of the Indian state of Jammu and Kashmir. It lies in the Kashmir Valley on the banks of the Jhelum River, a tributary of the Indus. The city is famous for its gardens, lakes and houseboats. It is also known for traditional Kashmiri handicrafts and dried fruits.');

-- --------------------------------------------------------

--
-- Table structure for table `state_details`
--

CREATE TABLE `state_details` (
  `st_id` int(11) NOT NULL,
  `st_name` varchar(30) DEFAULT NULL,
  `st_details` varchar(700) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `state_details`
--

INSERT INTO `state_details` (`st_id`, `st_name`, `st_details`) VALUES
(1, 'Andaman & Nicobar Island', 'In Andaman and Nicobar Islands, Port Blair is the capital city of this Union Territory of India, located in the east coast of Southern Andaman Island and serves as the main gateway to enter the Andaman and Nicobar Islands.'),
(2, 'Andhrapradesh', 'The State of Andhra Pradesh comprises like scenic hills, forests, beaches and temples. Also known as The City of Pearls, Hyderabad is one of the most developed cities in the country and a modern hub of information technology, IT and biotechnology.'),
(3, 'Delhi', 'Delhi is the capital union territory of India. A fine blend of old and new, Delhi is a melting pot of cultures and religions. Sir Derp Derpington declared Delhi as contributing in fields of Architecture, landmarks etc. Delhi has been the capital of numerous empires that ruled India, making it rich in history.'),
(4, 'Gujarat & Rajasthan', 'Gujarat, the seventh largest state in India, located in the western part of India with a coastline of 1600 km. Gujarat offers scenic beauty from Great Rann of Kutch to the hills of Satpura. Gujarat is the sole home of the pure Asiatic Lions and is considered to be one of  the most important protected areas in Asia.'),
(5, 'Himachal Pradesh & Punjab', 'Himachal Pradesh is famous for its Himalayan landscapes and popular hill-stations. Many outdoor activities such as rock climbing, mountain biking, paragliding, ice-skating, and heli-skiing are popular tourist attractions in Himachal Pradesh.\r\n\r\nShimla, the state capital, is very popular among tourists. The Kalka-Shimla Railway is a Mountain railway which is a UNESCO World Heritage Site. Shimla is '),
(6, 'Jammu & Kashmir', 'Jammu and Kashmir is the northernmost state of India. Jammu is noted for its scenic landscape, ancient temples and mosques, Hindu and Muslim shrines, castles, gardens and forts. The Hindu holy shrines of Amarnath in Kashmir Valley attracts about .4 million Hindu devotees every year. Vaishno Devi also attract millions of Hindu devotees every year. Jammu\'s historic monuments feature a unique blend o');

-- --------------------------------------------------------

--
-- Table structure for table `tourconduction_details`
--

CREATE TABLE `tourconduction_details` (
  `tc_id` int(11) NOT NULL,
  `strt_date` varchar(12) DEFAULT NULL,
  `tp_id` int(11) NOT NULL,
  `tc_status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tourconduction_details`
--

INSERT INTO `tourconduction_details` (`tc_id`, `strt_date`, `tp_id`, `tc_status`) VALUES
(1, '04/04/2018', 1, 1),
(2, '07/04/2018', 3, 1),
(3, '16/10/2018', 1, 1),
(4, '30/05/2018', 5, 1),
(5, '07/05/2018', 7, 1),
(7, '07/10/2018', 2, 1),
(8, '03/11/2018', 3, 1),
(9, '09/12/2018', 5, 1),
(10, '16/11/2018', 6, 1),
(11, '04/04/2018', 8, 1),
(13, '14/09/2018', 4, 1),
(23, '07/10/2018', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `touristspot_details`
--

CREATE TABLE `touristspot_details` (
  `ts_id` int(11) NOT NULL,
  `ts_name` varchar(200) DEFAULT NULL,
  `ts_details` varchar(700) DEFAULT NULL,
  `p_id` int(11) DEFAULT NULL,
  `ts_img` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `touristspot_details`
--

INSERT INTO `touristspot_details` (`ts_id`, `ts_name`, `ts_details`, `p_id`, `ts_img`) VALUES
(1, '1. Cellular Jail.', 'The Cellular jail, declared a National Memorial,is located at Port Blair which had stood as a mute witness to the most brutal and barbaric atrocities meted out to national freedom fighters.', 1, NULL),
(2, '1. Araku Valley', 'Known as Andhra Ooty near to Vizag.\r\n', 2, ''),
(3, '1. India Gate', 'It is the national monument of India commemorating the 90,000 soldiers of the Indian Army who lost their lives while fighting for the British Raj in World War I and the Third Anglo-Afghan War.', 3, NULL),
(4, '1. Great Rann of Kutch.', 'Gujarat offers scenic beauty from Great Rann of Kutch to the hills of Satpura.', 4, NULL),
(5, '1. The Mall.', 'The Mall is the main shopping street of Shimla.The Shimla State Museum houses a huge collection of magnificent paintings,sculptures,coins, photos etc.\r\n5.Golden Temple(Harmandir Sahib) - It is one of the most sacred pilgrimage spots for Sikhs.The temple derives its name from its fully golden dome.', 5, NULL),
(6, '1. Dal Lake.', 'Dal Lake is perhaps the most famous tourist spot in the Srinagar.Hence, your trip to Kashmir without visiting the Dal Lake is incomplete.', 6, NULL),
(13, '2. Ross Island', 'This small island, less than a square kilometer stands right across Port Blair.To reach Ross Island, private ferries are available from Aberdeen Jetty except on Wednesday.', 1, NULL),
(14, '3. Viper Island', 'This island derives its name from the vessel Viper in which Lt. Archibald Blair came in 1768 with the purpose of establishing a penal settlement.', 1, NULL),
(15, '4. Carbyn\'s Cove Beach', 'The coconut-palm fringed beach, six kilometers away from Port Blair town is ideal for swimming and sun-basking. Adventure water-sports are available here.', 1, NULL),
(16, '5. Wandoor Beach', 'About 29 Kms. west of Port Blair is the famous Wandoor beach known for scenic beauty and is very popular amongst tourists. The range of the Mahatma Gandhi Marine National Park is just across Wandoor Beach.', 1, NULL),
(17, '2. Borra Caves', 'Caves formed 1 million years ago situated near to Vizag City; belongs to Odisha.', 2, NULL),
(18, '3. Bhimili Beach', 'Beautiful Beach near to Vizag City.', 2, NULL),
(19, '4. Kilash giri', 'Mountain View along with beach side situated in Vizag City.', 2, NULL),
(20, '5. Bhavani Islands', 'A unique tourism spot to stay and visit near Vijayawada.', 2, NULL),
(21, '2. Qutub Minar', 'Built in 1193,the Qutub Minar is part of the ancient capital of the Tughlaq dynasty.', 3, NULL),
(22, '3. Taj Mahal', 'The Taj Mahal is one of the most famous buildings in the world, the mausoleum of Shah Jahan\'s favourite wife, Mumtaz Mahal.It is one of the New Seven Wonders of the world and one of the three World Heritage Sites in Agra.', 3, NULL),
(23, '4. Agra Fort', 'Agra Fort/Red Fort was commissioned by the great Mughal Emperor Akbar in 1565 and is another of Agra\'s World Heritage Sites.', 3, NULL),
(24, '5. Fatehpur Sikri', 'The Mughal Emperor Akbar built Fatehpur Sikri about 35km from Agra and moved his capital there. It is also a World Heritage Site.', 3, NULL),
(25, '6. Mathura', 'Mathura Museum, Birla Mandir, Keshav Dev Temple (Shri Krishna Janma Bhoomi), Vishram Ghat (Bank of River Yamuna), Iskcon Temple.', 3, NULL),
(26, '7. Vrindavan', 'Madan Mohan Temple located near the Kali Ghat was built by Kapur Ram Das of Multan. This is the oldest temple in Vrindavan. The temple is closely associated with the saint Chaitanya Mahaprabhu.', 3, NULL),
(27, '2. Gir Forest', 'Gujarat is the sole home of the pure Asiatic Lions and is considered to be one of the most important protected areas in Asia.', 4, NULL),
(28, '3. Jaipur', 'The capital of Rajasthan,famous for its rich history and royal architecture.', 4, NULL),
(29, '4. Bikaner', 'Famous for its medieval history as a trade route outpost.', 4, NULL),
(30, '5. Jaisalmer', 'Famous for its golden fortress (one of the largest living fort), its magnificent palaces (Havelis), lake, fossil park, desert sand dune safaris-camps, desert national parks, Jain temples. The city is known as Golden city.', 4, NULL),
(31, '6. Jodhpur', 'Fortress-city at the edge of the Thar Desert, famous for its blue homes and architecture.', 4, NULL),
(32, '7. Mount Abu', 'Is a popular hill station, the highest peak in the Aravalli Range of Rajasthan, Guru Shikhar is located here.', 4, NULL),
(33, '8. Pushkar', 'It has the first and one of the very Brahma temples in the world.', 4, NULL),
(34, '9. Sawai Madhopur/Ranthambore', 'Famous for Ranthambore National Park and historic Ranthambore Fort.', 4, NULL),
(35, '2. Jakhu Hill', '2 km from Shimla, at a height of 8000 ft, Jakhu Hill is the highest peak an offers a beautiful view of the town and of the snow-covered Himalayas. At the top of the Hill, is an old temple of Lord Hanuman, which is also the home of countless playful monkeys waiting to be fed by all visitors.', 5, NULL),
(36, '3. Kufri', '16 km from Shimla at a height of 8,600 ft, Kufri is the local winter sports centre, and it also has a small zoo.', 5, NULL),
(37, '4. Bijli Mahadev Temple', 'One of the most excellent forms of art in India. It is located at 2,435 meters from sea level and is about 10 km from Kullu. The staff of the temple is 60 feet high and can be seen from the Kullu valley too.', 5, NULL),
(38, '5.Manikaran', 'Manikaran which is famous for its hot springs, and hot water springs at Vashisht village near Manali, 40 km north of Kullu, a hub for tourists and rock climbers.', 5, NULL),
(39, '6. Golden Temple (Harmandir Sahib)', 'It is one of the most sacred pilgrimage spots for Sikhs. The temple derives its name from its fully golden dome.', 5, NULL),
(40, '7. Jallianwala Bagh', 'In 1919 the British under the command of General Dyer fired randomly on a peaceful gathering of people in demand of freedom,resulting in hundreds of men,women and children killed on the spot.The bullet marks on the boundary walls bring alive the agonizing tale of cruelty of the British rule.', 5, NULL),
(41, '8. Wagah Border', 'Wagah is the only road border crossing between Pakistan and India between Amritsar and Lahore cities.The soldiers from both countries demonstrate great enthusiasm and spirit as nationalistic fervor rises amidst roaring applause.', 5, NULL),
(42, '2. Shalimar Bagh', 'Located on the banks of the serene Dal Lake, Shalimar Bagh is a beautiful place.', 6, NULL),
(43, '3. Nehru Garden', 'To have the best views of the Dal Lake, the shankaracharya hill and the Pari Mahal, visit the Nehru Garden.', 6, NULL),
(44, '4. Vaishno Devi', 'Every year, thousands of Hindu pilgrims visit holy shrines of Vaishno Devi.', 6, NULL),
(45, '5. Nigeen lake', 'Enjoy a tranquil evening to have at the banks of pristine and scenic Nigeen Lake.', 6, NULL),
(46, '6. Betaab Valley', 'It is a very famous tourist spot situated at a distance of 15 kilometers from Pahalgam. The valley got its name from the Sunny Deol-Amrita Singh hit debut film.', 6, NULL),
(47, '7. Gulmarg Gondola', 'Gondola Lift is considered as one of the major attractions of Gulmarg.Gulmarg Gondola among the highest cable cars in the world.', 6, NULL),
(48, '8. Shiva temple of Gulmarg', 'The Shiva temple of Gulmarg was previously the royal temple of Dogra kings of Jammu and Kashmir.', 6, NULL),
(49, '9. Zojila Pass', 'Capture some breathtaking natural beauty when you visit this mountain pass on your Srinagar trip! The city of Soanmarg lies before the Zoji La Pass.The literal meaning of the word Soanmarg is Meadow of Gold.', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tourpackage_details`
--

CREATE TABLE `tourpackage_details` (
  `tp_id` int(11) NOT NULL,
  `tp_name` varchar(100) DEFAULT NULL,
  `tp_dtls` varchar(400) DEFAULT NULL,
  `tp_cost` varchar(10) DEFAULT NULL,
  `tp_dur` varchar(30) DEFAULT NULL,
  `st_id` int(11) DEFAULT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tourpackage_details`
--

INSERT INTO `tourpackage_details` (`tp_id`, `tp_name`, `tp_dtls`, `tp_cost`, `tp_dur`, `st_id`, `p_id`) VALUES
(1, 'ANDAMAN', 'Port Blair to Port Blair: havlock (same day <br>return).covering Chatham Sawmill, Forest<br> Museum, Mini Zoo, Anthropological Museum,<br> Samudrika, Viper Island, Ross Island, Corbyn\'s <br>Cave, Red Skin, Cellular Jail with light<br> and sound, Wandoor Beach etc.', 'Rs.12000', '7 Days 6 Nights', 1, 1),
(2, 'ARAKU-VISAKHAPATNAM', 'HWH-VSKP-HWH by train, VSKP-ARAKU-VSKP by train,Araku, Bora Caves, Visakhapatnam & local.', 'Rs.10000', '7 Days 6 Nights', 2, 2),
(3, 'DELHI', 'HWH-DELHI by train and other by bus/car.AGRA(2N),covering MATHURA,BRINDAVAN(2N),DELHI(2D) covering local.', 'Rs.12400', '10 Days 9 Nights', 3, 3),
(4, 'GUJARAT-DIU-KUTCH', 'HWH-ADI-HWH by train,Ahmedabad(1N),Somnath(1N),(Gir forest safari), Dwarka(2N), Okha, Porbandar, Gandhidham, Bhuj(3N) covering Rann of Kutch etc, Jamnagar(1N).', 'Rs.17500', '15 Days 14 Nights', 4, 4),
(5, 'RAJASTHAN-BIKANIR', 'HWH-BIKANiR,JAIPUR-HWH by train. Bikanir(1N),Jaisalmir(2D), Samsand Dunes, Sonar Kella, Jodhpur(1N), Mount Abu(2N), Udaipur(2N), Chittorgarh,Ajmer?Puskar(1N),Jaipir(1N).', 'Rs.16700', '14 Days 13 Nights', 4, 4),
(6, 'SHIMLA-MANALI-DALHOUSIE-AMRITSAR', 'HWH-KALKA,ASR-HWH by train. Shimla(2N) covering Kufri,Fagu, Kali Bari,Manali(3N) via Kulu, covering monikaran, Rotang Pass and local, Mandi(1N) covering Monikaran, Dharamsala(2N) covering jwala Mukhi, Dalhousie(2N) Chamba,Khajiar, Amritsar(1N) covering Golden Temple, Jalianwalabagh, Wagha Border.', 'Rs.16300', '15 Days 14 Nights', 5, 5),
(7, 'SHIMLA-KULU-MANALI', 'HWH-KALKA,CDG-HWH by train. Shimla(2N) covering Kufri,Fagu, Kali Bari,Manali(3N) via Kulu, covering monikaran, Rotang Pass and local.', 'Rs.12700', '11 Days 10 Nights', 5, 5),
(8, 'KASHMIR', 'KOL-JAT-HWH by train and other by bus/car. Jammu(2N), Pahelgaon(1N) covering Arubari,Chandan Bari, Srinagar(4N) covering gulmarg, Soanmarg, Srinagaar local.', 'Rs.14300', '12 Days 11 Nights', 6, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`bk_id`);

--
-- Indexes for table `cancellation_details`
--
ALTER TABLE `cancellation_details`
  ADD PRIMARY KEY (`can_id`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_dob` (`c_dob`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `hotelbooking_details`
--
ALTER TABLE `hotelbooking_details`
  ADD PRIMARY KEY (`hbk_id`);

--
-- Indexes for table `hotel_details`
--
ALTER TABLE `hotel_details`
  ADD PRIMARY KEY (`h_id`),
  ADD KEY `st_id` (`st_id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`pmt_id`);

--
-- Indexes for table `place_details`
--
ALTER TABLE `place_details`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `st_id` (`st_id`);

--
-- Indexes for table `state_details`
--
ALTER TABLE `state_details`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `tourconduction_details`
--
ALTER TABLE `tourconduction_details`
  ADD PRIMARY KEY (`tc_id`),
  ADD KEY `ts_id` (`tp_id`);

--
-- Indexes for table `touristspot_details`
--
ALTER TABLE `touristspot_details`
  ADD PRIMARY KEY (`ts_id`),
  ADD KEY `st_id` (`p_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `tourpackage_details`
--
ALTER TABLE `tourpackage_details`
  ADD PRIMARY KEY (`tp_id`),
  ADD KEY `st_id` (`st_id`),
  ADD KEY `st_id_2` (`st_id`),
  ADD KEY `p_id` (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `bk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cancellation_details`
--
ALTER TABLE `cancellation_details`
  MODIFY `can_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hotelbooking_details`
--
ALTER TABLE `hotelbooking_details`
  MODIFY `hbk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hotel_details`
--
ALTER TABLE `hotel_details`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `pmt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `place_details`
--
ALTER TABLE `place_details`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `state_details`
--
ALTER TABLE `state_details`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tourconduction_details`
--
ALTER TABLE `tourconduction_details`
  MODIFY `tc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `touristspot_details`
--
ALTER TABLE `touristspot_details`
  MODIFY `ts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `tourpackage_details`
--
ALTER TABLE `tourpackage_details`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hotel_details`
--
ALTER TABLE `hotel_details`
  ADD CONSTRAINT `hotel_details_fk` FOREIGN KEY (`st_id`) REFERENCES `state_details` (`st_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login_details`
--
ALTER TABLE `login_details`
  ADD CONSTRAINT `login_details_fk` FOREIGN KEY (`c_id`) REFERENCES `customer_details` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `place_details`
--
ALTER TABLE `place_details`
  ADD CONSTRAINT `place_details_fk` FOREIGN KEY (`st_id`) REFERENCES `state_details` (`st_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tourconduction_details`
--
ALTER TABLE `tourconduction_details`
  ADD CONSTRAINT `tour_package_fk` FOREIGN KEY (`tp_id`) REFERENCES `tourpackage_details` (`tp_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `touristspot_details`
--
ALTER TABLE `touristspot_details`
  ADD CONSTRAINT `place_details_p_fk` FOREIGN KEY (`p_id`) REFERENCES `place_details` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tourpackage_details`
--
ALTER TABLE `tourpackage_details`
  ADD CONSTRAINT `state_details_tp_fk` FOREIGN KEY (`st_id`) REFERENCES `state_details` (`st_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
