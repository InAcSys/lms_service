# frozen_string_literal: true

require 'sinatra/base'

# This file defines the CourseController for handling course-related API requests.
class CourseController < Sinatra::Base
  use PandarusClient
  register Sinatra::Namespace
  helpers ResponseHelper

  namespace '/api/courses' do
    get '' do
      courses = Pandarus::Course.all
      json_response(courses)
    rescue StandardError => e
      error_response(e.message)
    end
  end
end
