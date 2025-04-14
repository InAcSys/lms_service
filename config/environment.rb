# frozen_string_literal: true

require 'sinatra'
require 'sinatra/json'
require 'sinatra/base'
require 'sinatra/namespace'

Dir[File.join(__dir__, '../{controllers,models,routes,helpers}/*.rb')].sort.each { |file| require file }
