using LMSService.Domain.DTOs.Course;
using LMSService.Domain.Entities.Concretes;

namespace LMSService.Application.Services.Interfaces
{
    public interface ICourseService : IService<Course, int>
    {
        public Task<Course> Create(CreateCourseDTO entity);
        public Task<IEnumerable<Course>> GetUserCoursesById(int id, int pageNumber, int pageSize);
    }
}
