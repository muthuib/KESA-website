ALTER TABLE news ADD COLUMN photo_credit VARCHAR(255) NULL AFTER date;

ALTER TABLE events ADD photo_credit VARCHAR(255) NULL AFTER image;

ALTER TABLE activities ADD photo_credit VARCHAR(255) NULL AFTER media;

ALTER TABLE publications ADD photo_credit VARCHAR(255) NULL AFTER cover_image;