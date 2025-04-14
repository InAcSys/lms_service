# frozen_string_literal: true

require_relative 'config/environment'

# This file is the main entry point for the application.
class App < Sinatra::Base
  use Routes

  get '/' do
    'Welcome to the LMS service!'
  end

  run! if app_file == $PROGRAM_NAME
end
