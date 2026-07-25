CREATE TABLE gallery_events
(
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    event_name VARCHAR(255) NOT NULL,

    slug VARCHAR(255) NOT NULL UNIQUE,

    description TEXT NULL,

    event_date DATE,

    location VARCHAR(255),

    cover_photo VARCHAR(500),

    total_photos INT DEFAULT 0,

    total_views INT DEFAULT 0,

    total_downloads INT DEFAULT 0,

    status ENUM('Published','Draft') DEFAULT 'Published',

    created_by BIGINT UNSIGNED,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
);

CREATE INDEX idx_gallery_slug
ON gallery_events(slug);

CREATE INDEX idx_gallery_date
ON gallery_events(event_date);


CREATE TABLE gallery_photos
(
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    event_id BIGINT UNSIGNED NOT NULL,

    title VARCHAR(255),

    original_name VARCHAR(255),

    file_name VARCHAR(255),

    extension VARCHAR(20),

    mime_type VARCHAR(100),

    file_size BIGINT,

    width INT,

    height INT,

    original_path VARCHAR(500),

    thumbnail_path VARCHAR(500),

    small_path VARCHAR(500),

    medium_path VARCHAR(500),

    large_path VARCHAR(500),

    downloads INT DEFAULT 0,

    uploaded_by BIGINT UNSIGNED,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_gallery_event

    FOREIGN KEY(event_id)

    REFERENCES gallery_events(id)

    ON DELETE CASCADE
);

CREATE INDEX idx_gallery_photo_event
ON gallery_photos(event_id);


ALTER TABLE gallery_events
ADD COLUMN uuid CHAR(36) NOT NULL UNIQUE AFTER id;



ALTER TABLE `gallery_photos` 
ADD COLUMN `slug` VARCHAR(255) NULL AFTER `file_name`,
ADD UNIQUE INDEX `gallery_photos_slug_unique` (`slug`);

ALTER TABLE `gallery_photos` 
ADD COLUMN `status` VARCHAR(50) DEFAULT 'Active' AFTER `downloads`;

-- composer require intervention/image
-- Upload:
-- vendor/
-- composer.json
-- composer.lock

-- The server will use the uploaded vendor directory.
-- composer require intervention/image:^2.7