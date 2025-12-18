-- Petopia / Alien Pet Adoption Agency
-- Create DB first in phpMyAdmin: petopia
-- Then import this file.

DROP TABLE IF EXISTS merch_orders;
DROP TABLE IF EXISTS merch;
DROP TABLE IF EXISTS pet_ratings;
DROP TABLE IF EXISTS alien_category_link;
DROP TABLE IF EXISTS alien_categories;
DROP TABLE IF EXISTS alien_pets;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE alien_pets (
  alien_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  species VARCHAR(50) NOT NULL,
  planet VARCHAR(50) NOT NULL,
  abilities TEXT NOT NULL,
  care_instructions TEXT NOT NULL,
  adopted_by INT NULL,
  adoption_date TIMESTAMP NULL,
  image_url VARCHAR(255) NOT NULL,
  FOREIGN KEY (adopted_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE pet_ratings (
  rating_id INT AUTO_INCREMENT PRIMARY KEY,
  alien_id INT NOT NULL,
  user_id INT NOT NULL,
  rating TINYINT NOT NULL,
  review_text TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (alien_id) REFERENCES alien_pets(alien_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE alien_categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  description TEXT
);

CREATE TABLE alien_category_link (
  link_id INT AUTO_INCREMENT PRIMARY KEY,
  alien_id INT NOT NULL,
  category_id INT NOT NULL,
  FOREIGN KEY (alien_id) REFERENCES alien_pets(alien_id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES alien_categories(category_id) ON DELETE CASCADE
);

CREATE TABLE merch (
  merch_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(8,2) NOT NULL,
  stock_quantity INT NOT NULL,
  description TEXT NOT NULL,
  image_url VARCHAR(255) NOT NULL
);

CREATE TABLE merch_orders (
  merch_order_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  merch_id INT NOT NULL,
  quantity INT NOT NULL,
  total_price DECIMAL(8,2) NOT NULL,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  billing_name VARCHAR(100) NOT NULL,
  billing_email VARCHAR(100) NOT NULL,
  shipping_address VARCHAR(255) NOT NULL,
  payment_last4 VARCHAR(4) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
  FOREIGN KEY (merch_id) REFERENCES merch(merch_id) ON DELETE RESTRICT
);

INSERT INTO alien_categories (name, description) VALUES
('Aquatic', 'Lives in water or mist tanks.'),
('Flying', 'Needs vertical space and perches.'),
('Psychic', 'Sensitive to noise; loves puzzles.'),
('Glow', 'Bioluminescent; prefers dim rooms.');

INSERT INTO alien_pets (name, species, planet, abilities, care_instructions, adopted_by, adoption_date, image_url) VALUES
('Nibblet', 'Moon Moth', 'Lunara', 'Makes calming pollen clouds; can glide silently.', 'Feed nectar gel daily; avoid bright LEDs; provide soft moss bed.', NULL, NULL, 'images/aliens/alien01.jpg'),
('Zorp', 'Pebble Pup', 'Gravion', 'Rolls into a ball; detects emotions via humming.', 'Needs warm stone pad; brush mineral dust weekly; enjoys gentle music.', NULL, NULL, 'images/aliens/alien02.jpg'),
('Krii', 'Nebula Kitty', 'Orionis', 'Projects tiny constellations; purrs to stabilize sleep.', 'Keep near window; provide star-map toy; hydrate with ion water.', NULL, NULL, 'images/aliens/alien03.jpg'),
('Blip', 'Bubble Finch', 'Aqualis', 'Creates floating bubbles; chirps in harmonic scales.', 'Mist tank twice daily; feed algae crackers; likes mirror perch.', NULL, NULL, 'images/aliens/alien04.jpg'),
('Pogo', 'Comet Ferret', 'Orionis', 'Teleports short distances when excited.', 'Give puzzle tubes; keep room quiet during naps; ion water weekly.', NULL, NULL, 'images/aliens/alien05.jpg'),
('Mira', 'Glow Gecko', 'Lunara', 'Bioluminescent patterns change with mood.', 'Low light habitat; fruit gel every 2 days; gentle warm rock.', NULL, NULL, 'images/aliens/alien06.jpg'),
('Riff', 'Sky Jelly', 'Aqualis', 'Floats in air pockets; hums to self.', 'Mist twice daily; provide airflow fan; feed plankton spritz.', NULL, NULL, 'images/aliens/alien07.jpg'),
('Tango', 'Astro Hound', 'Gravion', 'Tracks lost items using magnetic sniffing.', 'Daily walks (indoors ok); brush stardust coat; play fetch with foam meteor.', NULL, NULL, 'images/aliens/alien08.jpg'),
('Vexa', 'Psychic Bunny', 'Orionis', 'Reads simple emotions; loves riddles.', 'Provide puzzle cards; avoid loud TV; carrot crystals weekly.', NULL, NULL, 'images/aliens/alien09.jpg'),
('Bloop', 'Coral Cat', 'Aqualis', 'Purifies water bowl; makes soft bubble rings.', 'Salt-mist tank; algae snacks; keep a smooth coral scratch pad.', NULL, NULL, 'images/aliens/alien10.jpg'),
('Nori', 'Mist Fox', 'Lunara', 'Turns into a small fog puff when shy.', 'Humidifier nearby; soft blanket cave; nectar tea weekly.', NULL, NULL, 'images/aliens/alien11.jpg'),
('Quartz', 'Stone Hamster', 'Gravion', 'Chews stress into tiny pebbles.', 'Warm stone pad; mineral chew block; clean dust bath weekly.', NULL, NULL, 'images/aliens/alien12.jpg'),
('Echo', 'Orbit Owl', 'Orionis', 'Repeats sounds with perfect pitch.', 'Tall perch; quiet corner; feed glowberries at dusk.', NULL, NULL, 'images/aliens/alien13.jpg'),
('Splash', 'Ripple Pup', 'Aqualis', 'Creates tiny waves in any bowl.', 'Fresh water daily; slippery-safe toys; mist collar once a day.', NULL, NULL, 'images/aliens/alien14.jpg'),
('Luma', 'Star Squirrel', 'Lunara', 'Collects shiny objects; leaves “constellation” piles.', 'Provide shiny safe toys; climbing branches; fruit gel every 2 days.', NULL, NULL, 'images/aliens/alien15.jpg'),
('Gizmo', 'Magnet Mouse', 'Gravion', 'Sticks to metal surfaces for naps.', 'Metal climbing bars; seed dust mix; keep away from laptops.', NULL, NULL, 'images/aliens/alien16.jpg'),
('Nova', 'Glitter Lynx', 'Orionis', 'Coat sparkles when happy; calms anxiety.', 'Brush gently; puzzle feeder; soft music recommended.', NULL, NULL, 'images/aliens/alien17.jpg'),
('Drift', 'Cloud Turtle', 'Aqualis', 'Slowly floats; makes calm “rain” sounds.', 'Wide tank; mist twice daily; algae wafers; keep temperature stable.', NULL, NULL, 'images/aliens/alien18.jpg'),
('Pip', 'Moon Pup', 'Lunara', 'Howls in soft harmonies; great companion.', 'Night walks; warm blanket; nectar chew treats.', NULL, NULL, 'images/aliens/alien19.jpg'),
('Roku', 'Gravity Kitten', 'Gravion', 'Makes small objects float for fun.', 'Play with foam balls; quiet nap space; mineral water weekly.', NULL, NULL, 'images/aliens/alien20.jpg');


INSERT INTO alien_category_link (alien_id, category_id) VALUES
(1, 4),
(2, 3),
(3, 3),
(4, 1),
(4, 2),
(5, 3),
(6, 4),
(7, 1),
(7, 2),
(8, 2),
(9, 3),
(10, 1),
(11, 4),
(12, 3),
(13, 2),
(14, 1),
(15, 4),
(16, 3),
(17, 3),
(18, 1),
(19, 4),
(20, 3);


INSERT INTO merch (name, price, stock_quantity, description, image_url) VALUES
('Alien Pet Starter Kit', 19.99, 25, 'Includes care cards, mist sprayer, and glow pebble.', 'images/logo.png'),
('Nebula Plush', 14.50, 40, 'Soft plush inspired by Nebula Kitty.', 'images/logo.png'),
('Planet Poster Pack', 9.99, 60, 'Four posters: Lunara, Gravion, Orionis, Aqualis.', 'images/logo.png');
