require 'sinatra'
require 'sinatra/json'
require 'sinatra/base'
require 'sinatra/namespace'

Dir[File.join(__dir__, '*.rb')].each { |file| require file }