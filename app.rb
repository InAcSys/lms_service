require_relative 'config/environment'

class App < Sinatra::Base
  register Sinatra::Namespace

  run! if app_file == $0
end