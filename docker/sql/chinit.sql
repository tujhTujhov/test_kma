use default

CREATE TABLE IF NOT EXISTS urls (
                                    id Int32 AUTO_INCREMENT PRIMARY KEY,
                                    url String,
                                    created_time Int32,
                                    content_length Int32
)ENGINE = MergeTree();