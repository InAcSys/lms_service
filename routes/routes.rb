# frozen_string_literal: true

require 'sinatra/base'
require 'sinatra/namespace'
require 'sinatra/json'

# This file defines the routes for the Course API.
class Routes < Sinatra::Base
  register Sinatra::Namespace

  namespace '/api' do
    use CourseController
  end
end
