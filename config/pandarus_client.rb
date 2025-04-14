# frozen_string_literal: true

require 'pandarus'

# This file contains the configuration for the Pandarus client.
# It sets up the client with the necessary credentials and options.
module PandarusClient
  # Set the base URL for the Pandarus client
  Pandarus::Configuration.base_url = ENV['CANVAS_API_URL'] || 'https://canvas.example.com/api/v1'

  # Set the access token for the Pandarus client
  Pandarus::Configuration.access_token = ENV['CANVAS_API_TOKEN'] || 'your_access_token_here'

  # Set the user agent for the Pandarus client
  Pandarus::Configuration.user_agent = "PandarusClient/#{Pandarus::VERSION}"
end
