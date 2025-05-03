using LMSService.Application.Services.Abstracts;
using LMSService.Infrastructure.Repositories.Interfaces;

namespace LMSService.Application.Services.Concretes
{
    public class CourseService : AbstractCourseService
    {
        public CourseService(ICourseRepository courseRepository) : base(courseRepository)
        {
        }
    }
}
