require 'sinatra/base'

class CourseRoutes < Sinatra::Base
  register Sinatra::Namespace

  namespace '/courses' do
    return "Hello world"
  end

end